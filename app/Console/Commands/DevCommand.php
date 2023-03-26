<?php

namespace App\Console\Commands;

use App\Http\Filter\Var1\WorkerFilter;
use App\Http\Filter\Var2\Worker\From;
use App\Http\Filter\Var2\Worker\To;
use App\Http\Filter\Var2\Worker\Name;
use App\Jobs\SomeJob;
use App\Models\Avatar;
use App\Models\Client;
use App\Models\Department;
use App\Models\Position;
use App\Models\Project;
use App\Models\ProjectWorker;
use App\Models\Review;
use App\Models\Tag;
use Illuminate\Console\Command;
use App\Models\Worker;
use App\Models\Profile;
use Illuminate\Pipeline\Pipeline;

class DevCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'develop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Some develops';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
//        $this->prepareData();
//        $this->prepareManyToMany();
//        dd('Stop');

        // Получение рабочего от профиля на уровне БД
        //$profile = Profile::find(1);
        //$worker = Worker::find($profile->worker_id);
        //dd($worker->toArray());

        // Получение профиля рабочего на уровне БД
        $worker = Worker::find(1);
        //$profile = Profile::find($worker->id);  // сам придумал
        //или как в видео:
        //$profile = Profile::where('worker_id', $worker->id)->first();
        //dd($profile->toArray());

        // То же самое, но на уровне модели
        //$profile = Profile::find(1);
        //dd($profile->worker->toArray());
        // и наоборот
        //$worker = Worker::find(2);
        //dd($worker->profile->toArray());

        // Отношение один ко многим
        // I. Через БД
        $position = Position::find(1);
        //$worker = Worker::where('position_id', $position->id)->get(); // нашли с позицией 1
        //dd($worker->toArray());
        $worker = Worker::whereIn('id', [1, 2, 3])->get(); // нашли с позицией 1, но уже зная их id
        //dd($worker->toArray());
        $posID = $worker->pluck('position_id')->unique();
        //$position = Position::find($posID[0]);

        $position = Position::whereIn('id', $posID)->get();
        //dd($position->toArray());

        // 2. Через laravel
        $worker = Worker::find(1);
        //dd($worker->position->toArray());
        $position = Position::find(1);
        //dd($position->workers->toArray());

        // Отношение многие ко многим
        // Задача: найти всех рабочих первого проекта
        // I. Через БД
        $project = Project::find(1);


        //$projectWorker = ProjectWorker::where('project_id', $project->id)->get();
        //$workerIds =  $projectWorker->pluck('worker_id')->toArray();
        //$workers = Worker::whereIn('id', $workerIds)->get();
        //dd($workers->toArray());

        // 2. Через laravel
        //dd($project->workers->toArray());

        // Задача: найти все Проекты первого рабочего
        $worker = Worker::find(1);
        //dd($worker->projects->toArray());

        //Специальные методы для отношения многие ко многим
//        $worker = Worker::find(2);
//        $project = Project::find(1);
//        //$worker->projects()->attach($project->id); // добавить связь
//        $worker->projects()->toggle($project->id);   // переключить связь
//
//        // групповое добавление
//        $worker2 = Worker::find(1);
//        $worker3 = Worker::find(3);
//        $project->workers()->attach([$worker->id, $worker2->id, $worker3->id]);
//        $project->workers()->detach($worker->id);

        //dd($worker->toArray());

        // Через (throwgh)
        // Задача: выцепить боса рабочего департамента IT
        // I. Через БД
        //$department = Department::find(2);
        //$position = Position::where('department_id', $department->id)->where('title', 'Boss')->first();
        //dd($position->toArray());
        //$worker = Worker::where('position_id', $position->id)->first();
        //dd($worker->toArray());

        // 2. Через laravel
        //dd($department->boss->toArray());

        // Задача: выцепить департамент рабочего
        // 2. Через laravel
        //dd($worker->position->department->toArray());

        // Задача: выцепить всех рабочих департамента IT
        // 2. Через laravel
        //dd($department->workers->toArray());

        // с конвенцией laravel
        $worker = Worker::find(1);
        //dd($worker->profile->toArray()); // Получаем профиль
        //dd($worker->projects->toArray()); // Получаем проекты

        //Полиморфы
        // Добавление аватаров (полиморф один к одному)
//        $worker = Worker::find(5);
//
//        $worker->avatar()->create([
//            'path' => 'some path'
//        ]);
//
//        $client = Client::find(1);
//
//        $client->avatar()->create([
//            'path' => 'client path'
//        ]);
//
//        $avatar = Avatar::find(7);
//        //dd($avatar->avatarable->toArray());
//
//        // Добавление аватаров (полиморф один ко многим)
//        $worker->reviews()->create([
//            'body' => 'body 1'
//        ]);
//
//        $worker->reviews()->create([
//            'body' => 'body 2'
//        ]);
//
//        $worker->reviews()->create([
//            'body' => 'body 3'
//        ]);
//
//        $client->reviews()->create([
//            'body' => 'body 1'
//        ]);
//
//        $client->reviews()->create([
//            'body' => 'body 2'
//        ]);
//
//        $client->reviews()->create([
//            'body' => 'body 3'
//        ]);
//
//        //dd($worker->reviews->toArray()); // Все отзывы, которые отправлял рабочий №5
//        $review = Review::find(18);
//        //dd($review->reviewable->toArray()); // Кто отравил отзыв №1
//
//        $worker->tags()->attach([1, 3]);
//        $client->tags()->attach([2, 3]);
//
//        $tag = Tag::find(3);
//        //dd($tag->workers->toArray()); // посмотреть у кого тег №3 из рабочих
//        //dd($tag->clients->toArray()); // посмотреть у кого тег №3 из клиентов
//
//        $position = Position::find(1);
//        //dd($position->queryWorker->toArray());

        // обновление для демонстрации событий и слушателей
        $worker = Worker::first();
        $worker->update([
            'name' => "Vanya"
        ]);



//        $profile = Profile::first();
//        $profile->delete();


        //$worker->delete();

        $worker = Worker::withTrashed();
        //dd($worker->count());

//        $worker = Worker::withTrashed()->find(1);
//        $worker->restore();
//        $worker = Worker::all();
//        //dd($worker->count());
//
//        //SomeJob::dispatch()->onQueue('some_queue');
//
//        $workerQuery = Worker::query();
//
//        $filter = new WorkerFilter(['from' => 20, 'to' => 22]);
//        $filter->applyFilter($workerQuery);
//
//        dd($workerQuery->get());

        request()->merge(['age_from' => 34, 'age_to' => 40, 'name' => null]);

        $workers = app()->make(Pipeline::class)
            ->send(Worker::query())
            ->through([
                From::class,
                To::class,
                Name::class,
            ])
            ->thenReturn();


        dd($workers->get());
    }

    public function prepareData(): void
    {
       Client::create([
           'name' => 'Bob'
       ]);

       Client::create([
           'name' => 'John'
       ]);

       Client::create([
           'name' => 'Elena'
       ]);


        $department1 = Department::create([
            'title' => 'IT',
        ]);

        $department2 = Department::create([
            'title' => 'Analytics',
        ]);


        $position1 = Position::create([
            'title' => 'Developer',
            'department_id' => $department1->id,
        ]);

        $position2 = Position::create([
            'title' => 'Manager',
            'department_id' => $department1->id,
        ]);

        $position3 = Position::create([
            'title' => 'Designer',
            'department_id' => $department1->id,
        ]);

        $workerData1 = [
            'name' => 'Ivan',
            'surname' => 'Ivanov',
            'email' => 'Ivan@mail.ru',
            'position_id' => $position1->id,
            'age' => 20,
            'description' => 'Some description',
            'is_married' => false,
        ];

        $workerData2 = [
            'name' => 'Karl',
            'surname' => 'Petrov',
            'email' => 'Karl@mail.ru',
            'position_id' => $position2->id,
            'age' => 28,
            'description' => 'Some description',
            'is_married' => true,
        ];

        $workerData3 = [
            'name' => 'Kate',
            'surname' => 'Krasavina',
            'email' => 'Kate@mail.ru',
            'position_id' => $position1->id,
            'age' => 18,
            'description' => 'Some description',
            'is_married' => false,
        ];

        $workerData4 = [
            'name' => 'John',
            'surname' => 'Johnet',
            'email' => 'John@mail.ru',
            'position_id' => $position1->id,
            'age' => 18,
            'description' => 'Some description',
            'is_married' => false,
        ];

        $workerData5 = [
            'name' => 'Liza',
            'surname' => 'Lizova',
            'email' => 'Liza@mail.ru',
            'position_id' => $position1->id,
            'age' => 18,
            'description' => 'Some description',
            'is_married' => true,
        ];

        $workerData6 = [
            'name' => 'Sofia',
            'surname' => 'Safina',
            'email' => 'Sofia@mail.ru',
            'position_id' => $position1->id,
            'age' => 18,
            'description' => 'Some description',
            'is_married' => false,
        ];

        $worker1 = Worker::create($workerData1);
        $worker2 = Worker::create($workerData2);
        $worker3 = Worker::create($workerData3);
        $worker4 = Worker::create($workerData4);
        $worker5 = Worker::create($workerData5);
        $worker6 = Worker::create($workerData6);

        $profileData1 = [
            //'worker_id' => $worker1->id, // Если по конвенции, то убираем
            'city' => 'Tokio',
            'skill' => 'Coder',
            'expierience' => 5,
            'finished_study_at' => '2020-06-01',
        ];

        $profileData2 = [
            //'worker_id' => $worker2->id, // Если по конвенции, то убираем
            'city' => 'Rio',
            'skill' => 'Boss',
            'expierience' => 10,
            'finished_study_at' => '2014-06-01',
        ];

        $profileData3 = [
            //'worker_id' => $worker3->id, // Если по конвенции, то убираем
            'city' => 'Oslo',
            'skill' => 'Frontend',
            'expierience' => 1,
            'finished_study_at' => '2021-06-01',
        ];

        $profileData4 = [
            //'worker_id' => $worker4->id, // Если по конвенции, то убираем
            'city' => 'London',
            'skill' => 'Frontend',
            'expierience' => 1,
            'finished_study_at' => '2021-06-01',
        ];

        $profileData5 = [
            //'worker_id' => $worker5->id, //  Если по конвенции, то убираем
            'city' => 'Perm',
            'skill' => 'Frontend',
            'expierience' => 1,
            'finished_study_at' => '2021-06-01',
        ];

        $profileData6 = [
            //'worker_id' => $worker6->id, // Если по конвенции, то убираем
            'city' => 'Kirov',
            'skill' => 'Frontend',
            'expierience' => 1,
            'finished_study_at' => '2021-06-01',
        ];

        // Если по конвенции, то убираем
//        $profile1 = Profile::create($profileData1);
//        $profile2 = Profile::create($profileData2);
//        $profile3 = Profile::create($profileData3);
//        $profile4 = Profile::create($profileData4);
//        $profile5 = Profile::create($profileData5);
//        $profile6 = Profile::create($profileData6);

        // И добавляем
        $worker1->profile()->create($profileData1);
        $worker2->profile()->create($profileData2);
        $worker3->profile()->create($profileData3);
        $worker4->profile()->create($profileData4);
        $worker5->profile()->create($profileData5);
        $worker6->profile()->create($profileData6);


        //dd($profile1->id);
    }

    public function prepareManyToMany(): void
    {
        $workerManager = Worker::find(2);
        $workerBackend = Worker::find(1);
        $workerDesigner1 = Worker::find(5);
        $workerDesigner2 = Worker::find(6);
        $workerFrontend1 = Worker::find(4);
        $workerFrontend2 = Worker::find(3);

        $project1 = Project::create([
            'title' => 'Shop',
        ]);

        $project2 = Project::create([
            'title' => 'Blog',
        ]);

        // Если по конвенции
        $project1->workers()->attach([
            $workerManager->id,
            $workerBackend->id,
            $workerDesigner1->id,
            $workerFrontend1->id
        ]);

        $project2->workers()->attach([
            $workerManager->id,
            $workerBackend->id,
            $workerDesigner2->id,
            $workerFrontend2->id
        ]);

        // Бес конвенции
//        ProjectWorker::create([
//            'project_id'=> $project1->id,
//            'worker_id'=> $workerManager->id,
//        ]);
//
//        ProjectWorker::create([
//            'project_id'=> $project1->id,
//            'worker_id'=> $workerBackend->id,
//        ]);
//
//        ProjectWorker::create([
//            'project_id'=> $project1->id,
//            'worker_id'=> $workerDesigner1->id,
//        ]);
//
//        ProjectWorker::create([
//            'project_id'=> $project1->id,
//            'worker_id'=> $workerFrontend1->id,
//        ]);
//
//        ProjectWorker::create([
//            'project_id'=> $project2->id,
//            'worker_id'=> $workerManager->id,
//        ]);
//
//        ProjectWorker::create([
//            'project_id'=> $project2->id,
//            'worker_id'=> $workerBackend->id,
//        ]);
//
//        ProjectWorker::create([
//            'project_id'=> $project2->id,
//            'worker_id'=> $workerDesigner2->id,
//        ]);
//
//        ProjectWorker::create([
//            'project_id'=> $project2->id,
//            'worker_id'=> $workerFrontend2->id,
//        ]);




    }
}
