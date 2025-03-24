<?php

namespace Tests\Feature\Http\Controllers\Grade;

use App\Models\Grade;
use Database\Factories\GradeFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;


/**
 * Class GradeControllerTest
 *
 * This class tests CRUD operations for the GradeController, including:
 * - Viewing the list of grades
 * - Creating a new grade
 * - Updating an existing grade
 * - Deleting a grade
 *
 * **Important Notes:**
 * - I use the **Arrange, Act, Assert (AAA) pattern**:
 *   - **Arrange:** Set up test data.
 *   - **Act:** Perform the action (e.g., send a request).
 *   - **Assert:** Check the result (e.g., database changes, response status).
 * - I make sure the correct status codes, views, and database updates are tested.
 * - I disable localization middleware to prevent unexpected redirects in tests.
 * - The `login()` function is **not built into PHPUnit**—I created it in the `TestCase` class to handle authentication easily.
 *
 * If you don’t know about the AAA pattern, I recommend reading about it to improve test structure.
 */


class GradeControllerTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_displays_the_grades_list_page()
    {
        // Arrange: Create 3 test grades using factory
        $grades = GradeFactory::new()->count(3)->create();

        // Act: Call the index route
        $response = $this->login()->get(route('Grades.index'));

        // Assert: Page loads successfully
        $response->assertStatus(200);
        $response->assertViewIs('pages.Grades.grades');
    }

    /** @test */
    public function it_stores_a_new_grade_successfully()
    {
        // Arrange: Generate grade data using factory
        $gradeData = GradeFactory::new()->make()->toArray();


        // Act: Send a POST request to store route
        $response = $this->login()->post(route('Grades.store'), [
            'Name_en' => $gradeData['Name']['en'],
            'Name' => $gradeData['Name']['ar'],
            'Notes' => $gradeData['Notes'],
        ]);

        // Assert: Grade is created in the database
        $this->assertDatabaseHas('grades', [
            'Name' => json_encode($gradeData['Name']),
            'Notes' => $gradeData['Notes'],
        ]);

        // Assert: Redirected to index page with success message
        $response->assertRedirect(route('Grades.index'));
    }


    /** @test */
    public function test_it_updates_a_grade_successfully()
    {
        // Arrange: Create a grade using factory
        $grade = GradeFactory::new()->create([
            'Name' => ['en' => 'Old Name', 'ar' => 'الاسم القديم'],
            'Notes' => 'Old Notes',
        ]);

        // Act: Send a PATCH request to update the grade
        $response = $this->login()->patch(route('Grades.update', ['id' => $grade->id]), [
            'id' => $grade->id,
            'Name_en' => 'Updated Grade',
            'Name' => 'الصف المحدث',
            'Notes' => 'Updated Notes',
        ]);

        // Assert: Grade is updated in the database
        $this->assertDatabaseHas('grades', [
            'id' => $grade->id,
            'Notes' => 'Updated Notes',
        ]);

        // Assert: Redirected to index page
        $response->assertRedirect(route('Grades.index'));
    }

    /** @test */
    public function it_deletes_a_grade_successfully()
    {
        // Arrange: Create a grade using factory
        $grade = GradeFactory::new()->create();

        // Act: Send a DELETE request with the correct ID
        $response = $this->login()->delete(route('Grades.destroy', $grade->id));

        // Assert: Grade is deleted from the database
        $this->assertDatabaseMissing('grades', ['id' => $grade->id]);

        // Assert: Redirected to index page
        $response->assertRedirect(route('Grades.index'));
    }



    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(LocaleSessionRedirect::class);
    }
}