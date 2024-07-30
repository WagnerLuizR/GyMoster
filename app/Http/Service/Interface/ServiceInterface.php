<?php

namespace App\Service;

interface ServiceInterface {

    public function index($pesquisar, $perPage);
   
    public function store($request);
 
    public function show($id);
      
    public function update($request, $id);
   
    public function destroy($id);
  
}
