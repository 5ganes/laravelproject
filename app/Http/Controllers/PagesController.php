<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
    	$title = 'Home - Laravel Test Project';
    	// return view('pages/index', compact('title'));
    	return view('pages/index')->with('title', $title);
    }

    public function about(){
    	$title = 'About Us';
    	return view('pages/about')->with('title', $title);
    }

    public function services(){
    	$data = [
    		'title' => 'Our Services',
    		'services' => ['Web Design', 'Web Development', 'Web Programming']

    	];
    	return view('pages/services')->with($data);
    }
}
