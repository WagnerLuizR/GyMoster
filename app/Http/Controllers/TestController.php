<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class TestController extends Controller
{
  public function show()
  {
    return Inertia::render('User/Test');
  }
}