<?php

namespace App\Http\Controllers\Api;

use App\ConfigProject\Constants;
use App\Http\Requests\User\UserDataRequest;
use App\Http\Requests\User\UserImageDataRequest;
use App\Http\Requests\User\UserPasswordDataRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserSkillsDataRequest;
use App\Http\Requests\User\UsersRequest;
use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\User\UserResource;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends BaseController
{

    public function index (UsersRequest $request)
    {
        $itemIds = $request->get('ids', []);
        $perPage = $request->get('per_page', Constants::PAGINATE_PER_PAGE);
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

    public function saveImage(UserImageDataRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $item = User::find($id);

            $item->clearMediaCollection($item->getTable());
            $imageBase64 = $request->get('image');
            $fileName = $item->getId() . '_' . time() .'.png';
            $item->addMediaFromBase64($imageBase64)
                ->usingName($item->getName())->usingFileName($fileName)
                ->toMediaCollection($item->getTable());

            DB::commit();
            return $this->sendResponse('Successfully save image.', new UserProfileResource($item));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception in save image: ', ['exception' => $e]);
            return $this->sendError('Cannot save image.', [], 409);
        }
    }
    public function saveSkills(UserSkillsDataRequest $request, $id)
    {
        try {
            $item = User::find($id);

            $item->clearMediaCollection($item->getTable());
            $imageBase64 = $request->get('image');
            $fileName = $item->getId() . '_' . time() .'.png';
            $item->addMediaFromBase64($imageBase64)
                ->usingName($item->getName())->usingFileName($fileName)
                ->toMediaCollection($item->getTable());

            DB::commit();
            return $this->sendResponse('Successfully save image.', new UserProfileResource($item));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception in save image: ', ['exception' => $e]);
            return $this->sendError('Cannot save image.', [], 409);
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
