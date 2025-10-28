<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\TaskGroupController;
use App\Repositories\TaskGroupRepository;
use App\Models\TaskGroup;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class TaskGroupControllerTest extends TestCase
{
    protected MockInterface $repositoryMock;
    protected TaskGroupController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = $this->mock(TaskGroupRepository::class);

        $this->controller = $this->app->make(TaskGroupController::class);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function index_should_return_all_task_groups()
    {
        $fakeCollection = new Collection([
            new TaskGroup(['name' => 'Group 1']),
            new TaskGroup(['name' => 'Group 2']),
        ]);

        $this->repositoryMock
            ->shouldReceive('getAllWithTasks')
            ->once()
            ->andReturn($fakeCollection);

        $response = $this->controller->index();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($fakeCollection->toJson(), $response->getContent());
    }

    #[Test]
    public function store_should_create_a_task_group()
    {
        $data = [
            'name' => 'Grup Baru',
            'description' => 'Deskripsi grup baru',
        ];

        $request = new Request($data);

        $fakeTaskGroup = new TaskGroup($data);
        $fakeTaskGroup->id = 1;

        $this->repositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($fakeTaskGroup);

        $response = $this->controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($fakeTaskGroup->toJson(), $response->getContent());
    }

    #[Test]
    public function show_should_return_a_single_task_group()
    {
        $id = 123;
        $fakeTaskGroup = new TaskGroup(['name' => 'Grup 123']);
        $fakeTaskGroup->id = $id;

        $this->repositoryMock
            ->shouldReceive('findOrFailWithTasks')
            ->once()
            ->with($id) // <-- Verifikasi ID-nya benar
            ->andReturn($fakeTaskGroup);

        $response = $this->controller->show($id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($fakeTaskGroup->toJson(), $response->getContent());
    }

    #[Test]
    public function show_should_return_404_if_not_found()
    {
        $id = 999;

        $this->repositoryMock
            ->shouldReceive('findOrFailWithTasks')
            ->once()
            ->with($id)
            ->andThrow(new ModelNotFoundException()); // <-- Ini kuncinya

        $response = $this->controller->show($id);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Task group not found']),
            $response->getContent()
        );
    }
    
    #[Test]
    public function update_should_modify_a_task_group()
    {
        $id = 1;
        $updateData = ['name' => 'Nama Baru'];
        $request = new Request($updateData);

        $updatedTaskGroup = new TaskGroup(['name' => 'Nama Baru']);
        $updatedTaskGroup->id = $id;

        $this->repositoryMock
            ->shouldReceive('update')
            ->once()
            ->with($id, $updateData) // <-- Cek ID dan datanya
            ->andReturn($updatedTaskGroup);

        $response = $this->controller->update($request, $id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($updatedTaskGroup->toJson(), $response->getContent());
    }

    #[Test]
    public function destroy_should_delete_a_task_group()
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
            json_encode(['message' => 'Task group deleted successfully']),
            $response->getContent()
        );
    }
}


