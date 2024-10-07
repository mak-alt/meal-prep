<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInscriptionRequest;
use App\Models\Inscription;
use Illuminate\View\View;

class InscriptionController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $inscriptions = Inscription::paginate(15);

        return \view('backend.inscriptions.index', compact('inscriptions'));
    }

    /**
     * @param \App\Models\Inscription $inscription
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Inscription $inscription): View
    {
        return \view('backend.inscriptions.edit', compact('inscription'));
    }

    public function update(Inscription $inscription, UpdateInscriptionRequest $request){
        try {
            $inscription->update([
                'data' => $request->data,
            ]);

            return redirect()->back()->with('success', 'Inscription has been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Inscription update failed.')->withInput();
        }

    }

}
