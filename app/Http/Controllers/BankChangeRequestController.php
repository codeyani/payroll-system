<?php

namespace App\Http\Controllers;

use App\Http\Resources\BankChangeRequestResource;
use App\Models\BankChangeRequest;
use App\Services\Interfaces\BankChangeRequestServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BankChangeRequestController extends Controller
{
    private BankChangeRequestServiceInterface $bankService;

    /**
     * Constructor to initialize the bank change request service.
     *
     * @param BankChangeRequestServiceInterface $bankService
     */
    public function __construct(BankChangeRequestServiceInterface $bankService)
    {
        $this->bankService = $bankService;
    }

    /**
     * HR views pending bank change requests.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        // Authorize viewing of pending requests
        Gate::authorize('viewAny', BankChangeRequest::class);
        // Retrieve pending requests
        $requests = $this->bankService->getPendingRequests();

        // Return as a collection of resources
        return BankChangeRequestResource::collection($requests);
    }

    /**
     * Employee submits a new bank change request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Authorize creation of a new request
        Gate::authorize('create', BankChangeRequest::class);
        // Create the bank change request
        $request = $this->bankService->createRequest($request);

        // Return a success response
        return response()->json([
            'message' => 'Request submitted successfully!',
            'request' => $request
        ], 201);
    }

    /**
     * Employee views their own submitted requests.
     *
     * @return AnonymousResourceCollection
     */
    public function myRequests(): AnonymousResourceCollection
    {
        // Authorize viewing of the user's own requests
        Gate::authorize('viewOwnRequests', BankChangeRequest::class);
        // Retrieve requests for the authenticated user
        $requests = $this->bankService->getUserRequests(Auth::id());
        
        // Return as a collection of resources
        return BankChangeRequestResource::collection($requests);
    }

    /**
     * Update an existing bank change request.
     *
     * @param Request $request
     * @param BankChangeRequest $bankChangeRequest
     * @return JsonResponse
     */
    public function update(Request $request, BankChangeRequest $bankChangeRequest): JsonResponse
    {
        // Authorize the update action
        Gate::authorize('update', $bankChangeRequest);
        // Update the request
        $updatedRequest = $this->bankService->updateRequest($bankChangeRequest, $request->all());

        // Return a success response
        return response()->json([
            'message' => 'Request updated successfully!',
            'request' => $updatedRequest
        ]);
    }
}
