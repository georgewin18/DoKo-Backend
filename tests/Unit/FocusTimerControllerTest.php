<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\FocusTimerController;
use App\Repositories\FocusTimerRepository;
use App\Models\FocusTimer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;

class FocusTimerControllerTest extends TestCase
{
    protected MockInterface $repositoryMock;
    protected FocusTimerController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->repositoryMock = $this->mock(FocusTimerRepository::class);
        
        $this->controller = $this->app->make(FocusTimerController::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function index_should_return_all_timers()
    {
        $fakeCollection = new Collection([
            new FocusTimer(['name' => 'Timer 1']),
            new FocusTimer(['name' => 'Timer 2']),
        ]);

        $this->repositoryMock
            ->shouldReceive('getAll')
            ->once()
            ->andReturn($fakeCollection);

        $response = $this->controller->index();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($fakeCollection->toJson(), $response->getContent());
    }

    #[Test]
    public function store_should_create_a_timer()
    {
        $data = [
            'name' => 'Sesi Belajar',
            'focus_time' => 50,
            'break_time' => 10,
            'section' => 4,
        ];
        $request = new Request($data);

        $fakeTimer = new FocusTimer($data);
        $fakeTimer->id = 1;

        $this->repositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($fakeTimer);

        $response = $this->controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($fakeTimer->toJson(), $response->getContent());
    }

    #[Test]
    public function show_should_return_a_single_timer()
    {
        $id = 123;
        $fakeTimer = new FocusTimer(['name' => 'Timer 123']);
        $fakeTimer->id = $id;

        $this->repositoryMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with($id)
            ->andReturn($fakeTimer);

        $response = $this->controller->show($id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($fakeTimer->toJson(), $response->getContent());
    }

    #[Test]
    public function show_should_return_404_if_not_found()
    {
        $id = 999;
        $this->repositoryMock
            ->shouldReceive('findOrFail')
            ->once()
            ->with($id)
            ->andThrow(new ModelNotFoundException());

        $response = $this->controller->show($id);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Timer not found']),
            $response->getContent()
        );
    }
    
    #[Test]
    public function update_should_modify_a_timer()
    {
        $id = 1;
        $updateData = ['name' => 'Nama Timer Baru'];
        $request = new Request($updateData);

        $updatedTimer = new FocusTimer($updateData);
        $updatedTimer->id = $id;

        $this->repositoryMock
            ->shouldReceive('update')
            ->once()
            ->with($id, $updateData)
            ->andReturn($updatedTimer);

        $response = $this->controller->update($request, $id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($updatedTimer->toJson(), $response->getContent());
    }

    #[Test]
    public function destroy_should_delete_a_timer()
    {
        $id = 1;
        $this->repositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with($id)
            ->andReturn(true); // Repo kita return boolean

        $response = $this->controller->destroy($id);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Timer deleted successfully']),
            $response->getContent()
        );
    }
}