<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Worker;
use App\Http\Resources\WorkerResource;
use App\Http\Requests\Worker\StoreRequest;
use App\Http\Requests\Worker\UpdateRequest;

class WorkerController extends Controller
{
    public function index() {
        $workers = Worker::all();

        // return response()->json([
        //     'data' => $workers,
        // ]);

        return WorkerResource::collection($workers)->resolve();
    }

    public function show(Worker $worker) {
        //return new WorkerResource($worker);  // или
        return WorkerResource::make($worker)->resolve();
    }

    public function store(StoreRequest $request) {
        $data = $request->validated();
        $worker = Worker::create($data);

        return WorkerResource::make($worker)->resolve();
    }

    public function update(UpdateRequest $request, Worker $worker) {
        $data = $request->validated();
        $worker->update($data);
        $worker->fresh();

        return WorkerResource::make($worker)->resolve();
    }

    public function destroy(Worker $worker) {
        $worker->delete();

        return response()->json([
            'message' => "Worker succefully deleted"
        ]);
    }
}
