<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserModel;
use Exception;


class UserController extends Controller
{
  protected $user;

  public function __construct(UserModel $user)
  {
    $this->user =$user;
  }

  public function register(Request $request)
  {
    $user = [
      "name" => $request->name,
      "email" => $request->email,
      "password" => md5($request->password)
    ];

    try
    {
      $user = $this->user->create($user);
      return response('Created',201);
    }
    catch(Exception $ex)
    {
      return response('Failed',400);
    }
  }

  public function all()
  {
    try
    {
      $user = $this->user->with('item')->get();
      return $user;
    }
    catch(Exception $ex)
    {
      return response('Failed',400);
    }
  }

  public function find($id)
  {
    $user = $this->user->find($id);
    return $user;
  }

  public function update(Request $request, $id)
  {
    try
    {
      $query = $this->user->find($id);

      $name = $request->name;
      $email = $request->email;
      $password = md5($request->password);

      $query->name = $name;
      $query->email = $email;
      $query->password = $password;

      $update = $query->save();

      return response('Updated',201);
    }
    catch (Exception $e)
    {
      return $e;
      return response('Failed',400);
    }
  }

  public function delete($id)
  {
    try
    {
      $user = $this->user->where('id',$id)->delete();
      return response('Deleted',201);
    }
    catch(Exception $ex)
    {
      return response('Failed',400);
    }
  }

}
