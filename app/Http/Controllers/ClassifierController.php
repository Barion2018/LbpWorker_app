<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassifierController extends Controller
{
    public function start() {
        return view('classifier.start');
    }

    public function disassembly() {
        return view('classifier.disassembly');
    }

    public function analyzer() {
        return view('classifier.analyzer');
    }

    public function search() {
        return view('classifier.search');
    }
    

    
    
}
