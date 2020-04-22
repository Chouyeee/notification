<?php

namespace Ichen\Notification\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ichen\Notification\NotificationService;

class NotificationController extends Controller
{
    protected $service;

    public function __construct(NotificationService $service)
    {
        $this->service = $service;
    }

    public function line(Request $request)
    {
        $this->service->line($request->message);

        return ;
    }

    public function sms(Request $request)
    {
        $this->service->sms($request->phone_number, $request->message);

        return ;
    }
}
