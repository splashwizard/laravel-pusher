<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePusherRequest;
use App\Http\Requests\UpdatePusherRequest;
use App\Repositories\PusherRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PusherController extends AppBaseController
{
    /** @var  PusherRepository */
    private $pusherRepository;

    public function __construct(PusherRepository $pusherRepo)
    {
        $this->pusherRepository = $pusherRepo;
    }

    /**
     * Display a listing of the Pusher.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->pusherRepository->pushCriteria(new RequestCriteria($request));
        $pushers = $this->pusherRepository->all();

        return view('pushers.index')
            ->with('pushers', $pushers);
    }

    /**
     * Show the form for creating a new Pusher.
     *
     * @return Response
     */
    public function create()
    {
        return view('pushers.create');
    }

    /**
     * Store a newly created Pusher in storage.
     *
     * @param CreatePusherRequest $request
     *
     * @return Response
     */
    public function store(CreatePusherRequest $request)
    {
        $input = $request->all();

        $pusher = $this->pusherRepository->create($input);

        Flash::success('Pusher saved successfully.');

        return redirect(route('pushers.index'));
    }

    /**
     * Display the specified Pusher.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pusher = $this->pusherRepository->findWithoutFail($id);

        if (empty($pusher)) {
            Flash::error('Pusher not found');

            return redirect(route('pushers.index'));
        }

        return view('pushers.show')->with('pusher', $pusher);
    }

    /**
     * Show the form for editing the specified Pusher.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pusher = $this->pusherRepository->findWithoutFail($id);

        if (empty($pusher)) {
            Flash::error('Pusher not found');

            return redirect(route('pushers.index'));
        }

        return view('pushers.edit')->with('pusher', $pusher);
    }

    /**
     * Update the specified Pusher in storage.
     *
     * @param  int              $id
     * @param UpdatePusherRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePusherRequest $request)
    {
        $pusher = $this->pusherRepository->findWithoutFail($id);

        if (empty($pusher)) {
            Flash::error('Pusher not found');

            return redirect(route('pushers.index'));
        }

        $pusher = $this->pusherRepository->update($request->all(), $id);

        Flash::success('Pusher updated successfully.');

        return redirect(route('pushers.index'));
    }

    /**
     * Remove the specified Pusher from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pusher = $this->pusherRepository->findWithoutFail($id);

        if (empty($pusher)) {
            Flash::error('Pusher not found');

            return redirect(route('pushers.index'));
        }

        $this->pusherRepository->delete($id);

        Flash::success('Pusher deleted successfully.');

        return redirect(route('pushers.index'));
    }
}
