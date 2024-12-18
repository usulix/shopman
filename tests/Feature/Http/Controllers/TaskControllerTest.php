<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TaskController
 */
final class TaskControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $tasks = Task::factory()->count(3)->create();

        $response = $this->get(route('tasks.index'));

        $response->assertOk();
        $response->assertViewIs('task.index');
        $response->assertViewHas('tasks');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('tasks.create'));

        $response->assertOk();
        $response->assertViewIs('task.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TaskController::class,
            'store',
            \App\Http\Requests\TaskStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $description = $this->faker->text();
        $deliver_by_datetime = Carbon::parse($this->faker->dateTime());
        $unit = Unit::factory()->create();

        $response = $this->post(route('tasks.store'), [
            'description' => $description,
            'deliver_by_datetime' => $deliver_by_datetime->toDateTimeString(),
            'unit_id' => $unit->id,
        ]);

        $tasks = Task::query()
            ->where('description', $description)
            ->where('deliver_by_datetime', $deliver_by_datetime)
            ->where('unit_id', $unit->id)
            ->get();
        $this->assertCount(1, $tasks);
        $task = $tasks->first();

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('task.id', $task->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.show', $task));

        $response->assertOk();
        $response->assertViewIs('task.show');
        $response->assertViewHas('task');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task));

        $response->assertOk();
        $response->assertViewIs('task.edit');
        $response->assertViewHas('task');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TaskController::class,
            'update',
            \App\Http\Requests\TaskUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $task = Task::factory()->create();
        $description = $this->faker->text();
        $deliver_by_datetime = Carbon::parse($this->faker->dateTime());
        $unit = Unit::factory()->create();

        $response = $this->put(route('tasks.update', $task), [
            'description' => $description,
            'deliver_by_datetime' => $deliver_by_datetime->toDateTimeString(),
            'unit_id' => $unit->id,
        ]);

        $task->refresh();

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('task.id', $task->id);

        $this->assertEquals($description, $task->description);
        $this->assertEquals($deliver_by_datetime, $task->deliver_by_datetime);
        $this->assertEquals($unit->id, $task->unit_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));

        $this->assertModelMissing($task);
    }
}
