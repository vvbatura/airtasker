<?php

namespace App\Http\Controllers\Api;

use App\Constants\SystemConstants;
use App\Constants\TaskConstants;
use App\Http\Requests\Task\TaskDataRequest;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Requests\Task\TasksRequest;
use App\Http\Requests\Task\TasksShowRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Notifications\Task\CreatedTask;
use App\Notifications\Task\UpdatedTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends BaseController
{

    public function index(TasksShowRequest $request)
    {
        $tasks = Task::with('_location')->query();
        if ($userId =$request->get('user_id', null)) {
            $tasks = $tasks->where('user_id', $userId);
        }
        if ($price = $request->get('price', null)) {
            $tasks = $tasks->where(function ($query) use ($price) {
                $query->whereBetween('price_total', $price)
                    ->orWhereBetween('price_hourly', $price);
            });
        }
        if ($location =$request->get('location', null)) {
            $tasks = $tasks->where('user_id', $userId);
        } else {
            $tasks = $tasks->doesnthave('_location');
        }

        $type = $request->get('type', TaskConstants::TYPE_ALL);
        switch ($type) {
            case TaskConstants::TYPE_ALL:
                break;
            case TaskConstants::TYPE_POSTED:
                $tasks = $tasks->where('status', TaskConstants::STATUS_OPENED);
                break;
            case TaskConstants::TYPE_DRAFT:
                break;
            case TaskConstants::TYPE_ASSIGNED:
                break;
            case TaskConstants::TYPE_NOT_ASSIGNED:
                break;
            case TaskConstants::TYPE_OFFERS:
                break;
            case TaskConstants::TYPE_COMPLETED:
                $tasks = $tasks->where('status', TaskConstants::STATUS_OPENED);
                break;
        }
        $after = $request->get('after', 0);
        $tasks = $tasks->skip($after)->take(SystemConstants::PAGINATE_PER_PAGE)
            ->orderBy('created_at','desc')->get();

        return TaskResource::collection($tasks);
    }

    public function store(TaskDataRequest $request)
    {
        DB::beginTransaction();
        try{
            $data = $request->only(['title', 'details', 'date', 'price_total', 'price_hourly']);
            //$data['user_id'] = $user = $this->guard()->user()->id;
            $data['user_id'] = 1;
            $task = Task::create($data);
            if ($location = $request->get('location', null)) {
                $task->_location()->create($location);
            }

            $locale = $request->get('locale', SystemConstants::LANGUAGE_EN);
            try {
                $task->notify((new CreatedTask($task, $task->_user))->locale($locale));
            } catch (\Exception $e) {
                Log::error('Exception notify created task: ', ['exception' => $e]);
            }

            DB::commit();
            return $this->sendResponse('Successfully created task.', new TaskResource($task));

        } catch (\Exception $e){
            DB::rollBack();
            Log::error('Exception in created new task: ', ['exception' => $e]);
            return $this->sendError('Cannot created task.', [], 409);
        }
    }

    public function show(TaskRequest $request, $id)
    {
        $item = Task::find($id);

        return new TaskResource($item);
    }

    public function update(TaskDataRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $task = Task::with('_location')->find($id);
            $task->update($request->only(['title', 'details', 'date', 'price_total', 'price_hourly']));
            if ($locationData = $request->get('location', null)) {
                if ($location = $task->_location) {
                    $location->update($locationData);
                } else {
                    $task->_location()->update($locationData);
                }
            } else {
                if ($location = $task->_location) {
                    $location->delete();
                }
            }

            $locale = $request->get('locale', SystemConstants::LANGUAGE_EN);
            try {
                $task->notify((new UpdatedTask($task, $task->_user))->locale($locale));
            } catch (\Exception $e) {
                Log::error('Exception notify updated task: ', ['exception' => $e]);
            }

            DB::commit();
            return $this->sendResponse('Successfully updated task.', new TaskResource($task));

        } catch (\Exception $e){
            DB::rollBack();
            Log::error('Exception in updated task: ', ['exception' => $e]);
            return $this->sendError('Cannot updated task.', [], 409);
        }
    }

    public function cancel(TaskRequest $request, $id)
    {
        try {
            $task = Task::find($id);
            $task->update('status', TaskConstants::STATUS_CANCELED);
            return $this->sendResponse('Successfully canceled task.');

        } catch (\Exception $e) {
            Log::error('Exception canceled task: ', ['exception' => $e]);
            return $this->sendError('Cannot canceled task.', [], 409);
        }
    }

    public function delete(TaskRequest $request, $id)
    {
        try {
            Task::whereId($id)->delete();
            return $this->sendResponse('Successfully delete task.');

        } catch (\Exception $e) {
            Log::error('Exception deleted task: ', ['exception' => $e]);
            return $this->sendError('Cannot deleted task.', [], 409);
        }
    }

    public function deleteMany(TasksRequest $request)
    {
        try {
            Task::whereIn('id', $request->get('ids', []))->delete();
            return $this->sendResponse('Successfully deleted tasks.');

        } catch (\Exception $e) {
            Log::error('Exception deleted tasks: ', ['exception' => $e]);
            return $this->sendError('Cannot deleted tasks.', [], 409);
        }
    }

}
