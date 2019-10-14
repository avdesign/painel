@extends('errors::minimal')

@section('title', __(constLang('error.404')))
@section('code', '404')
@section('message', __(constLang('error.404')))
@section('redirect', __(constLang('back')))
