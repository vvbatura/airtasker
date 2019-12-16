<?php

namespace App\Http\Controllers\Api;

use App\ConfigProject\Constants;
use App\Http\Requests\User\UsersRequest;
use App\Http\Resources\User\UserResource;
use App\User;
use Illuminate\Support\Facades\DB;
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

        $items = User::
            when(count($itemIds), function ($query) use ($itemIds) {
                $query->whereIn('id', $itemIds);
            })
            ->sort($request)
            ->search($request)
            ->paginate($perPage);

        return UserResource::collection($items);
    }

    public function store(UserDataRequest $request)
    {
        DB::beginTransaction();
        try{
            $item = User::create($request->only('title', 'description'));

            if ($imageBase64 = $request->get('image', false)) {
                $fileName = $item->getId() . '_' . time() .'.png';
                $item->addMediaFromBase64($imageBase64)
                    ->usingName($item->getTitle()[Constants::LANGUAGE_EN])->usingFileName($fileName)
                    ->toMediaCollection($item->getTable());
            }

            DB::commit();
            return $this->sendResponse('Successfully create new category.', new CategoryResource($item));

        } catch (\Exception $e){
            DB::rollBack();
            Log::error('Exception in create new category: ', ['exception' => $e]);
            return $this->sendError('Cannot create category.', [], 409);
        }
    }

    public function show(CategoryRequest $request, $id)
    {
        $item = Category::relations()->find($id);

        return new CategoryResource($item);
    }

    public function update(CategoryDataRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $item = Category::find($id);
            $item->update($request->only('title', 'description'));

            $item->clearMediaCollection($item->getTable());
            if ($imageBase64 = $request->get('image', false)) {
                $fileName = $item->getId() . '_' . time() .'.png';
                $item->addMediaFromBase64($imageBase64)
                    ->usingName($item->getTitle()[Constants::LANGUAGE_EN])->usingFileName($fileName)
                    ->toMediaCollection($item->getTable());
            }

            DB::commit();
            return $this->sendResponse('Successfully update category.', new CategoryResource($item));

        } catch (\Exception $e){
            DB::rollBack();
            Log::error('Exception in update category: ', ['exception' => $e]);
            return $this->sendError('Cannot update category.', [], 409);
        }
    }

    public function delete(CategoryRequest $request, $id)
    {
        try {
            Category::whereId($id)->delete();
            return $this->sendResponse('Successfully delete category.');

        } catch (\Exception $e) {
            Log::error('Exception delete category: ', ['exception' => $e]);
            return $this->sendError('Cannot delete category.', [], 409);
        }
    }

    public function deleteMany(CategoriesRequest $request)
    {
        try {
            Category::whereIn('id', $request->get('ids', []))->delete();
            return $this->sendResponse('Successfully delete categories.');

        } catch (\Exception $e) {
            Log::error('Exception delete categories: ', ['exception' => $e]);
            return $this->sendError('Cannot delete categories.', [], 409);
        }
    }

}
