<?php

namespace App\Http\Controllers;

use App\Http\Filter\Var1\WorkerFilter;
use App\Http\Filter\Var2\Worker\From;
use App\Http\Filter\Var2\Worker\To;
use App\Http\Filter\Var2\Worker\Name;
use App\Http\Requests\Worker\StoreRequest;
use App\Http\Requests\Worker\UpdateRequest;
use App\Http\Requests\Worker\IndexRequest;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class WorkerController extends Controller
{
    public function index(IndexRequest $request)
    {
        //$data = $request->validated();

//        if (isset($data['name'])) {
//            $workerQuery->where('name', 'like', "%{$data['name']}%");
//        }
//
//        if (isset($data['surname'])) {
//            $workerQuery->where('surname', 'like', "%{$data['surname']}%");
//        }
//
//        if (isset($data['email'])) {
//            $workerQuery->where('email', 'like', "%{$data['email']}%");
//        }
//
//        if (isset($data['from'])) {
//            $workerQuery->where('age', '>', $data['from']);
//        }
//
//        if (isset($data['to'])) {
//            $workerQuery->where('age', '<', $data['to']);
//        }
//
//        if (isset($data['description'])) {
//            $workerQuery->where('description', 'like', "%{$data['description']}%");
//        }
//
//        if (isset($data['is_married'])) {
//            $workerQuery->where('is_married', true);
//        }

        //$filter = new WorkerFilter($data);
        // Другой вариант создания фильтра
        //$filter = app()->make(WorkerFilter::class, ['params' => $data]);
        //$workerQuery = Worker::filter($filter);


        // Второй тип фильтра
        $workers = app()->make(Pipeline::class)
            ->send(Worker::query())
            ->through([
                From::class,
                To::class,
                Name::class,
            ])
            ->thenReturn();



        //$workers  = $workerQuery->paginate(3); // для 1-го типа фильтра
        $workers  = $workers->paginate(3); // для 2-го типа фильтра

        return view('worker.index', compact('workers'));
    }

    public function show(Worker $worker)
    {
        return view('worker.show', compact('worker'));
    }

    public function create()
    {
        return view('worker.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Worker::class);

        $data = $request->validated();
        $data['is_married'] = isset($data['is_married']);

        Worker::create($data);
        return redirect()->route('workers.index');
    }

    public function edit(Worker $worker)
    {
        $this->authorize('update', $worker);

        return view('worker.edit', compact('worker'));
    }

    public function update(UpdateRequest $request, Worker $worker)
    {
        $this->authorize('update', $worker);

        $data = $request->validated();
        $data['is_married'] = isset($data['is_married']);

        $worker->update($data);

        return redirect()->route('workers.show', $worker->id);
    }

    public function destroy(Worker $worker)
    {
        $this->authorize('delete', $worker);

        $worker->delete();

        return redirect()->route('workers.index');
    }
}
