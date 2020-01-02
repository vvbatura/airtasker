<?php

namespace App\Http\Controllers\Api;

use App\Constants\SystemConstants;
use App\Http\Requests\User\UserDataRequest;
use App\Http\Requests\User\UserImageDataRequest;
use App\Http\Requests\User\UserNotificationDataRequest;
use App\Http\Requests\User\UserPasswordDataRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserSkillDataRequest;
use App\Http\Requests\User\UsersRequest;
use App\Http\Resources\User\UserNotificationResource;
use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserSkillResource;
use App\Models\NotificationUser;
use App\Models\UserSkill;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends BaseController
{

    public function index (UsersRequest $request)
    {
        $itemIds = $request->get('ids', []);
        $perPage = $request->get('per_page', SystemConstants::PAGINATE_PER_PAGE);
        if (count($itemIds)) {
            $perPage = $request->get('per_page', User::count());
        }

        $items = User::relations()
            ->when(count($itemIds), function ($query) use ($itemIds) {
                $query->whereIn('id', $itemIds);
            })
            ->sort($request)
            ->search($request)
            ->paginate($perPage);

        return UserResource::collection($items);
    }

    public function show(UserRequest $request, $id)
    {
        $item = User::relations()->find($id);

        return new UserProfileResource($item);
    }

    public function showSkills(UserRequest $request, $id)
    {
        $item = UserSkill::where('user_id', $id)->first();

        return new UserSkillResource($item);
    }

    public function showNotifications(UserRequest $request, $id)
    {
        $items = NotificationUser::with('_action')->where('user_id', $id)->get();

        return UserNotificationResource::collection($items);
    }

    public function update(UserDataRequest $request, $id)
    {
        $item = User::find($id);
        $email = $request->get('email');
        if ($item->getEmail() != $email && User::where('email', $email)->first()) {
            return $this->sendError('Email ' . $email . ' exists in DB.', [], 422);
        }
        $phone = $request->get('phone');
        if ($item->getEmail() != $phone && User::where('phone', $phone)->first()) {
            return $this->sendError('Phone ' . $phone . ' exists in DB.', [], 422);
        }

        DB::beginTransaction();
        try {
            $item->update($request->only([
                'first_name', 'last_name',
                'email', 'phone', 'type'
            ]));
            $item->_profile->update($request->only([
                'birth_date', 'sex',
                'tag_line', 'abn', 'description'
            ]));
            $item->_location->update($request->only('location'));

            DB::commit();
            return $this->sendResponse('Successfully update user.', new UserProfileResource($item));

        } catch (\Exception $e){
            DB::rollBack();
            Log::error('Exception in update user: ', ['exception' => $e]);
            return $this->sendError('Cannot update user.', [], 409);
        }
    }

    protected function saveImage($image, $item, $collection, $extension ='.png', $isReplace =false)
    {
        if($isReplace) {
            $item->clearMediaCollection($collection);
        }

        if (strpos($image, ';base64') !== false) {
            list($extensionImage, $image) = explode(';', $image);
            list(, $extensionImage) = explode('/', $extensionImage);
            list(, $image) = explode(',', $image);
            if ($extensionImage == 'jpeg') {
                $extensionImage = 'jpg';
            }
            if (in_array($extensionImage, SystemConstants::SAVE_fILE_EXTENSIONS)) {
                $extension = '.' . $extensionImage;
            }
        }

        $fileName = $item->getId() . '_' . $collection . '_' . time() . $extension;
        $item->addMediaFromBase64($image)
            ->usingName($item->getName())->usingFileName($fileName)
            ->toMediaCollection($collection);

        return $fileName;
    }

    public function saveAvatar(UserImageDataRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $item = User::find($id);
            $fileName = $this->saveImage($request->get('image'), $item, $item->getTable().'_avatar', '.png', true);

            DB::commit();
            return $this->sendResponse('Successfully save avatar.', $fileName);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception in save avatar: ', ['exception' => $e]);
            return $this->sendError('Cannot save avatar.', [], 409);
        }
    }

    public function saveResume(UserImageDataRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $item = User::find($id);
            $fileName = $this->saveImage($request->get('image'), $item, $item->getTable().'_resume', '.doc', true);

            DB::commit();
            return $this->sendResponse('Successfully save .', $fileName);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception in save resume: ', ['exception' => $e]);
            return $this->sendError('Cannot save resume.', [], 409);
        }
    }

    public function savePortfolio(UserImageDataRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $item = User::find($id);
            $fileNames = [];
            foreach ($request->get('image') as $image) {
                $fileNames[] = $this->saveImage($request->get('image'), $item, $item->getTable().'_portfolio');
            }

            DB::commit();
            return $this->sendResponse('Successfully save portfolio.', $fileNames);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception in save portfolio: ', ['exception' => $e]);
            return $this->sendError('Cannot save portfolio.', [], 409);
        }
    }

    public function saveSkills(UserSkillDataRequest $request, $id)
    {
        try {
            $item = UserSkill::find($id);

            $item->update($request->only([
                'good_at', 'get_around', 'languages', 'qualifications', 'experience',
            ]));

            return $this->sendResponse('Successfully save user skill.', new UserSkillResource($item));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception in save user skill: ', ['exception' => $e]);
            return $this->sendError('Cannot save user skill.', [], 409);
        }
    }

    public function saveNotification(UserNotificationDataRequest $request, $userId, $id)
    {
        try {
            $item = NotificationUser::find($id);

            $item->update($request->only([
                'email', 'sms', 'push'
            ]));

            return $this->sendResponse('Successfully save user notification.', new UserNotificationResource($item));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception in save user notification: ', ['exception' => $e]);
            return $this->sendError('Cannot save user notification.', [], 409);
        }
    }

    public function savePassword(UserPasswordDataRequest $request, $id)
    {
        try {
            $item = User::find($id);

            if (!Hash::check($request->get('current_password'), $item->password)) {
                return $this->sendError('Error current password.', [], 422);
            }
            $item->update([
                'password' => $request->get('password')
            ]);
            return $this->sendResponse('Successfully save password.', new UserProfileResource($item));

        } catch (\Exception $e) {
            Log::error('Exception in save password: ', ['exception' => $e]);
            return $this->sendError('Cannot save password.', [], 409);
        }
    }

    public function delete(UserRequest $request, $id)
    {
        try {
            User::whereId($id)->delete();
            return $this->sendResponse('Successfully delete user.');

        } catch (\Exception $e) {
            Log::error('Exception delete user: ', ['exception' => $e]);
            return $this->sendError('Cannot delete user.', [], 409);
        }
    }

    public function deleteMany(UsersRequest $request)
    {
        try {
            User::whereIn('id', $request->get('ids', []))->delete();
            return $this->sendResponse('Successfully delete users.');

        } catch (\Exception $e) {
            Log::error('Exception delete users: ', ['exception' => $e]);
            return $this->sendError('Cannot delete users.', [], 409);
        }
    }

}
