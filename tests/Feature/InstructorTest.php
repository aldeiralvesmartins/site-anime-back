<?php
/**
 * File: InstructorTest
 * Created by: divino
 * Created at: 06/12/2023
 */

namespace Tests\Feature;

use App\Models\Instructor;
use App\Models\Permission;
use App\Models\Person;
use App\Models\RolePermission;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class InstructorTest extends TestCase
{
    protected string $uri = '/api/instructor';

    use DatabaseTransactions;

    public function test_route_index_of_instructors(): void
    {
        $response = $this->withHeaders($this->authorization)->get($this->uri);

        $response->assertOk();
    }

    public function test_action_show_of_instructors(): void
    {
        $instructorId = Instructor::where('company_id', $this->company)->first('id')?->id;

        $this->assertNotNull($instructorId);

        $response = $this->withHeaders($this->authorization)->get("$this->uri/$instructorId?include[]=person");

        $body = $response->json();

        $response->assertOk();
        $this->assertNotEmpty($body);
        $response->assertJsonStructure(['id', 'person_id', 'gender', 'company_id', 'person' => ['taxpayer', 'name']]);
        $this->assertEquals($this->company, $body['company_id']);
    }

    public function test_action_active_inactive_of_instructor(): void
    {
        $instructor = Instructor::where('company_id', $this->company)?->with('person')?->first();

        $this->assertNotNull($instructor);
        $active = $instructor->person->active;

        $actionInactive = $this->withHeaders($this->authorization)->patch("$this->uri/active-or-inactive/$instructor->id");

        $actionInactive->assertOk();
        $instructor = Instructor::with('person')->find($instructor->id);

        $this->assertNotNull($instructor);
        $this->assertNotEquals($instructor->person->active, $active);
    }

    public function test_action_create_of_modalities(): void
    {
        $body = [
            'name' => 'João Gomes',
            'email' => 'joaozinhoteste@gmail.com',
            'taxpayer' => '901.215.990-35',
            'password' => 'sistema123',
            'address' => [
                'company_id' => $this->company,
                'zip_code' => '74015005',
                'street' => 'Avenida Tocantins',
                'neighborhood' => 'Setor Central',
                'complement' => 'até 544 - lado par',
                'city_id' => 5208707,
                'number' => '114'
            ],
            'phones' => [['number' => '(62) 9 8622-4464'], ['number' => '(62) 3326-3202']],
            'instructor' => [
                'level_schooling' => 'Ensino Fundamental Completo',
                'gender' => 'Male',
                'cref' => '425518-D/GO',
                'taxpayer_code' => '457582819',
                'birthdate' => '1996-05-20',
                'admission_date' => '2023-12-06',
                'instructor_modalities' => [49]
            ]
        ];

        $response = $this->withHeaders($this->authorization)->post($this->uri, $body);

        $response->assertCreated();
        $this->assertNotNull(Person::find($response->json('id')));
    }

    public function test_form_create_request_of_modalities(): void
    {
        $body = [
            'name' => '',
            'email' => 'joaozinhoteste',
            'taxpayer' => '9012159934324454332035',
            'address' => [
                'company_id' => $this->company,
                'zip_code' => '',
                'street' => '',
                'neighborhood' => '',
                'complement' => '',
                'city_id' => '',
                'number' => ''
            ],
            'phones' => [['number' => '']],
            'instructor' => [
                'level_schooling' => '',
                'gender' => 'Outro tipo',
                'cref' => '',
                'taxpayer_code' => '457582819',
                'birthdate' => '05-20',
                'admission_date' => '2023-06',
                'instructor_modalities' => []
            ]
        ];

        $response = $this->withHeaders($this->authorization)->post($this->uri, $body);

        $response->assertBadRequest();
        $response->assertJsonStructure(['validations' => ['code', 'message', 'errors' => ['msg' => []]]]);

        $messages = $response->json()['validations']['errors']['msg'];

        $this->assertContains(__('validation.required', ['attribute' => 'nome']), $messages);
        $this->assertContains(__('validation.max.string', ['attribute' => 'taxpayer', 'max' => '18']), $messages);
        $this->assertContains(__('validation.date_format', ['attribute' => 'instructor.birthdate', 'format' => 'Y-m-d']), $messages);
        $this->assertContains(__('validation.date_format', ['attribute' => 'instructor.admission date', 'format' => 'Y-m-d']), $messages);
        $this->assertContains(__('validation.exists', ['attribute' => 'instructor.gender']), $messages);
        $this->assertContains(__('validation.required', ['attribute' => 'address.zip code']), $messages);
        $this->assertContains(__('validation.required', ['attribute' => 'address.street']), $messages);
        $this->assertContains(__('validation.required', ['attribute' => 'address.neighborhood']), $messages);
        $this->assertContains(__('validation.required', ['attribute' => 'address.city id']), $messages);
        $this->assertContains(__('validation.required', ['attribute' => 'phones.0.number']), $messages);
    }

    public function test_action_update_of_instructors(): void
    {
        $instructor = Instructor::where('company_id', $this->company)->first();

        $this->assertNotNull($instructor);

        $oldCref = $instructor->cref;
        $newCref = '485155F/DD';

        $response = $this->withHeaders($this->authorization)
            ->put("$this->uri/$instructor->id", ['instructor' => ['cref' => $newCref]]);

        $response->assertOk();

        $instructor = Instructor::find($instructor->id);

        $this->assertNotNull($instructor);
        $this->assertNotEquals($oldCref, $newCref);
        $this->assertEquals($newCref, $instructor->cref);
    }

    public function test_permissions_of_routes_instructors(): void
    {
        $permissionsIds = Permission::where('name', 'ilike', '%InstructorController%')->pluck('id');

        RolePermission::whereIn('permission_id', $permissionsIds)->delete();

        $this->assertEquals(0, RolePermission::whereIn('permission_id', $permissionsIds)->count());

        $instructorId = Instructor::where('company_id', $this->company)->first('id')?->id;

        $index = $this->withHeaders($this->authorization)->get($this->uri);
        $show = $this->withHeaders($this->authorization)->get("$this->uri/$instructorId");
        $activeInactive = $this->withHeaders($this->authorization)->patch("$this->uri/active-or-inactive/$instructorId");
        $create = $this->withHeaders($this->authorization)->post($this->uri);
        $update = $this->withHeaders($this->authorization)->put("$this->uri/$instructorId");

        $index->assertUnauthorized();
        $show->assertUnauthorized();
        $activeInactive->assertUnauthorized();
        $create->assertUnauthorized();
        $update->assertUnauthorized();

        $index->assertJsonStructure(['validations' => ['code', 'message', 'errors' => ['msg' => []]]]);
        $this->assertEquals(__('auth.not_permited'), $index->json('validations')['errors']['msg'][0]);
        $this->assertEquals(__('auth.not_permited'), $show->json('validations')['errors']['msg'][0]);
        $this->assertEquals(__('auth.not_permited'), $activeInactive->json('validations')['errors']['msg'][0]);
        $this->assertEquals(__('auth.not_permited'), $create->json('validations')['errors']['msg'][0]);
        $this->assertEquals(__('auth.not_permited'), $update->json('validations')['errors']['msg'][0]);
    }
}
