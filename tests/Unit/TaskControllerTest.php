<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\TaskController;
use App\Repositories\TaskRepository;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test; 

class TaskControllerTest extends TestCase
{
    protected MockInterface $repositoryMock;
    protected TaskController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = $this->mock(TaskRepository::class);
        
        $this->controller = $this->app->make(TaskController::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function index_should_return_all_tasks()
    {
        $fakeCollection = new Collection([ new Task(['name' => 'Task 1']) ]);

        $this->repositoryMock
            ->shouldReceive('getAllWithGroup')
            ->once()
            ->andReturn($fakeCollection);

        $response = $this->controller->index();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($fakeCollection->toJson(), $response->getContent());
    }

    #[Test]
    public function store_should_create_a_task()
    {
        $data = [
            'name' => 'Task Baru',
            'date' => '2025-01-01',
            'time' => '10:00',
            'task_group_id' => 1,
        ];
        
        $dataWithProgress = $data + ['progress' => 0];

        $requestMock = $this->mock(Request::class);
        
        $requestMock->shouldReceive('validate')
                    ->once()
                    ->andReturn($data);
        
        $fakeTask = new Task($dataWithProgress);
        $fakeTask->id = 1;

        $this->repositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($dataWithProgress)
            ->andReturn($fakeTask);

        $response = $this->controller->store($requestMock);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($fakeTask->toJson(), $response->getContent());
    }

    #[Test]
    public function show_should_return_a_single_task()
    {
        $id = 1;
        $fakeTask = new Task(['name' => 'Task 1']);
        $fakeTask->id = $id;

        $this->repositoryMock
            ->shouldReceive('findOrFailWithGroup')
            ->once()
            ->with($id)
            ->andReturn($fakeTask);

        $response = $this->controller->show($id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($fakeTask->toJson(), $response->getContent());
    }

    #[Test]
    public function show_should_return_404_if_not_found()
    {
        $id = 999;
        $this->repositoryMock
            ->shouldReceive('findOrFailWithGroup')
            ->once()
            ->with($id)
            ->andThrow(new ModelNotFoundException());

        $response = $this->controller->show($id);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Task not found']),
            $response->getContent()
        );
    }
    
    #[Test]
    public function update_should_modify_a_task()
    {
        $id = 1;
        $updateData = ['name' => 'Nama Baru'];

        $requestMock = $this->mock(Request::class);
        
        $requestMock->shouldReceive('validate')
                    ->once()
                    ->andReturn($updateData);

        $updatedTask = new Task($updateData);
        $updatedTask->id = $id;

        $this->repositoryMock
            ->shouldReceive('update')
            ->once()
            ->with($id, $updateData)
            ->andReturn($updatedTask);

        $response = $this->controller->update($requestMock, $id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($updatedTask->toJson(), $response->getContent());
    }

    #[Test]
    public function destroy_should_delete_a_task()
    {
        $id = 1;
        $this->repositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with($id)
            ->andReturn(true);

        $response = $this->controller->destroy($id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Task deleted successfully']),
            $response->getContent()
        );
    }
}