<?php
/**
 * File: ModalityTest
 * Created by: divino
 * Created at: 03/12/2023
 */

namespace Tests\Feature;

use App\Models\Modality;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ModalityTest extends TestCase
{
    protected string $uri = '/api/modalities';

    use DatabaseTransactions;

    public function test_route_index_of_modalities(): void
    {
        $response = $this->withHeaders($this->authorization)->get($this->uri);

        $response->assertOk();
    }

    public function test_action_show_of_modalities(): void
    {
        $modalityId = Modality::where('name', 'Karatê')->where('company_id', $this->company)->first('id')?->id;

        $this->assertNotNull($modalityId);

        $response = $this->withHeaders($this->authorization)->get("$this->uri/$modalityId");

        $body = $response->json();

        $response->assertOk();
        $this->assertNotEmpty($body);
        $response->assertJsonStructure(['id', 'name', 'active', 'company_id']);
        $this->assertEquals($this->company, $body['company_id']);
    }

    public function test_action_delete_of_modalities(): void
    {
        $modalityId = Modality::where('company_id', $this->company)->first('id')?->id;

        $this->assertNotNull($modalityId);

        $response = $this->withHeaders($this->authorization)->delete("$this->uri/$modalityId");

        $response->assertOk();
        $this->assertEquals(__('messages.excluded_item'), $response->json('message'));

        $modality = Modality::find($modalityId);

        $this->assertNull($modality);
    }

    public function test_action_create_of_modalities(): void
    {
        $response = $this->withHeaders($this->authorization)->post($this->uri, ['name' => 'Nova Modalidade']);

        $response->assertCreated();
        $this->assertNotNull(Modality::find($response->json('id')));
    }

    public function test_action_update_of_modalities(): void
    {
        $modality = Modality::where('company_id', $this->company)->first();

        $this->assertNotNull($modality);

        $oldName = $modality->name;
        $newName = 'Novo nome Teste';

        $response = $this->withHeaders($this->authorization)
            ->put("$this->uri/$modality->id", ['name' => $newName]);

        $response->assertOk();

        $modality = Modality::find($modality->id);

        $this->assertNotNull($modality);
        $this->assertNotEquals($oldName, $newName);
        $this->assertEquals($newName, $modality->name);
    }

    public function test_form_create_request_of_modalities(): void
    {
        $response = $this->withHeaders($this->authorization)->post($this->uri, ['name' => '']);

        $response->assertBadRequest();
        $response->assertJsonStructure(['validations' => ['code', 'message', 'errors' => ['msg' => []]]]);
        $this->assertEquals(__('validation.required', ['attribute' => 'nome']), $response->json('validations')['errors']['msg'][0]);
    }

    public function test_permissions_of_routes_modalities(): void
    {
        $permissionsIds = Permission::where('name', 'ilike', '%ModalityController%')->pluck('id');

        RolePermission::whereIn('permission_id', $permissionsIds)->delete();

        $this->assertEquals(0, RolePermission::whereIn('permission_id', $permissionsIds)->count());

        $modalityId = Modality::where('name', 'Karatê')->where('company_id', $this->company)->first('id')?->id;

        $index = $this->withHeaders($this->authorization)->get($this->uri);
        $show = $this->withHeaders($this->authorization)->get("$this->uri/$modalityId");
        $delete = $this->withHeaders($this->authorization)->delete("$this->uri/$modalityId");
        $create = $this->withHeaders($this->authorization)->post($this->uri, ['name' => 'Nova Modalidade']);
        $update = $this->withHeaders($this->authorization)->put("$this->uri/$modalityId", ['name' => 'novo']);

        $index->assertUnauthorized();
        $show->assertUnauthorized();
        $delete->assertUnauthorized();
        $create->assertUnauthorized();
        $update->assertUnauthorized();

        $index->assertJsonStructure(['validations' => ['code', 'message', 'errors' => ['msg' => []]]]);
        $this->assertEquals(__('auth.not_permited'), $index->json('validations')['errors']['msg'][0]);
        $this->assertEquals(__('auth.not_permited'), $show->json('validations')['errors']['msg'][0]);
        $this->assertEquals(__('auth.not_permited'), $delete->json('validations')['errors']['msg'][0]);
        $this->assertEquals(__('auth.not_permited'), $create->json('validations')['errors']['msg'][0]);
        $this->assertEquals(__('auth.not_permited'), $update->json('validations')['errors']['msg'][0]);
    }
}
