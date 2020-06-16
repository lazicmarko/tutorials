<?php

namespace App\Http\Controllers\Admin;

use App\Models\Uloga;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends BackendController
{
    public function __construct()
    {
        parent::construct("admin.pages.roles", "Roles management", "Manage your user's roles", "roles.create", "roles.index");
        $this->roleModel = new Uloga();
    }
    public function index()
    {
        $this->data['roles'] = $this->roleModel->selectAll();
        return view($this->getView(), $this->data);
    }
    public function create()
    {
        $this->data['form'] = 'insert';
        return view($this->getView(), $this->data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha|min:2|max:20'
        ], $request->all());

        $this->roleModel->name = $request->get('name');
        try {
            $this->roleModel->insert();
            return redirect(route('roles.index'))->with("success", "Uloga je uspesno dodata!");
        } catch(QueryException $e) {
            \Log::error("Greška pri dodavanju uloge: " . $e->getMessage());
            return redirect()->back()->with("error", "An error has occurred! Please check the log file.");
        }
    }
    public function destroy($id)
    {
        try {
            $this->roleModel->delete($id);
            return redirect(route('roles.index'))->with("success", "Ruta uspesno obrisana!");
        } catch (QueryException $e) {
            \Log::error("Greska pri brisanju rute " . $e->getMessage());
            return redirect()->back()->with("error", "An error occurred, please try again later");
        }
    }
    public function show($id)
    {
        $this->data['form'] = 'edit';
        $this->data['role'] = $this->roleModel->selectOne($id);
        return view($this->getView(), $this->data);
    }    
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required'
        ];
        $validator = \Validator::make($request->all(), $rules);
        $validator->validate();

        try {
            $this->roleModel->name = $request->get("name");
            $this->roleModel->update($id);
            return redirect(route('roles.index'))->with("success", "Navigation link successfully updated!");
        } catch(QueryException $e) {
            \Log::error("Greska pri unosu izmeni linka " . $e->getMessage());
            return redirect()->back()->with("error", "An error occurred, please try again later");
        }
    }                 	
}
