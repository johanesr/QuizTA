<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemModel;
use Exception;

class ItemController extends Controller
{
  protected $item;

  public function __construct(ItemModel $item)
  {
    $this->item = $item;
  }

  public function register(Request $request)
  {
    $item =
    [
      "user_id" =>$request->user_id,
      "name" => $request->name,
      "price" => $request->price,
      "stock" => $request->stock
    ];

    try
    {
      $item = $this->item->create($item);
      return response('Created',201);
    }
    catch(Exception $ex)
    {
      return response('Failed',400);
    }
  }

  public function all()
  {
    $items = $this->item->all();
    return response()->json($items, 200);
  }

  public function find($id)
  {
    $item = $this->item->find($id);
    return $item;
  }

  public function update(Request $request, $id)
  {
    try
    {
      $query = $this->item->find($id);

      $user_id = $request->user_id;
      $name = $request->name;
      $price = $request->price;
      $stock = $request->stock;

      $query->user_id = $user_id;
      $query->name = $name;
      $query->price = $price;
      $query->stock = $stock;

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
    // return redirect('/all');
    try
    {
      $item = $this->item->where('id',$id)->delete();
      return response('Deleted',201);
    }
    catch(Exception $ex)
    {
      return response('Failed',400);
    }
  }

}
