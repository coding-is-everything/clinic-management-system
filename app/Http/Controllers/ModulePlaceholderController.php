<?php

namespace App\Http\Controllers;

use App\Support\ClinicModules;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ModulePlaceholderController extends Controller
{
    public function __invoke(Request $request): Response
    {
        // Note: with a Request $request parameter present, Laravel binds
        // extra scalar route parameters positionally rather than by name —
        // so $module must be read explicitly rather than type-hinted here.
        $definition = ClinicModules::find($request->route('module'));

        abort_if($definition === null, SymfonyResponse::HTTP_NOT_FOUND);

        return Inertia::render('modules/coming-soon', [
            'module' => $definition,
        ]);
    }
}
