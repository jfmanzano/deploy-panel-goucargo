<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class TemplateController extends Controller
{
    public function templates()
    {
        $templates = Template::all();
        $users = User::all();
        return view("templates", compact("templates", "users"));
    }
    public function createTemplate()
    {
        return view('create-template');
    }
    public function storeTemplate(Request $request)
    {
        $template = new Template;
        $template->name = $request->name;
        $template->customer_fields = $request->customerFields;
        $template->own_fields = "order_code;order_comments;send_to_name;send_to_address;send_to_zipcode;send_to_village_neighborhood;send_to_city;send_to_phone_number;send_to_person;sku;quantity";
        $template->save();
        Alert::success('TEMPLATE CREATED SUCCESSFULLY', '');
        return redirect('templates');
    }
    public function updateTemplate(Request $request)
    {
        Template::where('name',$request->name)->update([
            'name'=> $request->name,
            'customer_fields' => $request->customerFields
        ]);
        Alert::success('TEMPLATE UPDATED SUCCESSFULLY', '');
        return redirect('templates');
    }
    public function editTemplate($id)
    {
        $template = Template::where('id', $id)->first();
        return view('edit-template', compact('template'));
    }
    public function editUserTemplate($id)
    {
        $user = User::where('id', $id)->first();
        $templates = Template::all();
        return view('edit-user-template', compact('user','templates'));
    }
    public function updateUserTemplate(Request $request)
    {
        User::where('user',$request->user)->update([
            'template_id' => $request->template
        ]);
        Alert::success('USER TEMPLATE UPDATED SUCCESSFULLY', '');
        return redirect('templates');
    }

}
