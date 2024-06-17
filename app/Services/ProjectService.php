<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

/**
 * Class ProjectService.
 */
class ProjectService
{
    private static function startFundraising($projectId, $fundraisingPeriodData)
    {
        $project = ProjectService::getProjectById($projectId);

        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Proses Penggalangan Dana');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('on_fundraising');

        self::updateProjectStatus($project, $categoryProjectSubmissionStatus);

        $fundraisingPeriodData['status'] = $subCategoryProjectSubmission->name;
        $project->campaign->update($fundraisingPeriodData);

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
        ]);
    }

    public static function acceptContract($projectId, $acceptanceData)
    {
        $project = ProjectService::getProjectById($projectId);
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Proses Tanda Tangan Kontrak');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('contract_signed_accepted');

        self::updateProjectStatus($project, $categoryProjectSubmissionStatus);

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
        ]);

        self::startFundraising($projectId, $acceptanceData);
    }

    public static function uploadSignedContract($projectId, $contractDocument)
    {
        $project = ProjectService::getProjectById($projectId);

        self::attachMediaToProject($project, $contractDocument, 'project_contract_document', false);

        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Proses Tanda Tangan Kontrak');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('contract_signed');

        self::updateProjectStatus($project, $categoryProjectSubmissionStatus);

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
        ]);
    }

    private static function signingContract($projectId)
    {
        $project = ProjectService::getProjectById($projectId);
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Proses Tanda Tangan Kontrak');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('on_contract_signing');

        self::updateProjectStatus($project, $categoryProjectSubmissionStatus);

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
        ]);
    }

    public static function rejectCommittee($projectId, $rejectionData)
    {
        $project = ProjectService::getProjectById($projectId);
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Proses Approval Komitee');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('rejected_by_committee');

        self::updateProjectStatus($project, $categoryProjectSubmissionStatus);

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
        ]);

        self::reject($projectId, $rejectionData);
    }

    public static function approveCommittee($projectId, $approvalData)
    {
        $project = ProjectService::getProjectById($projectId);
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Proses Approval Komitee');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('approved_by_committee');

        self::updateProjectStatus($project, $categoryProjectSubmissionStatus);

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
        ]);

        $initiateCampaignData = [
            'approved_amount' => $approvalData['approved_amount'],
            'offered_token_amount' => $approvalData['offered_token_amount'],
            'price_per_unit' => self::calculatePricePerUnit($approvalData['offered_token_amount'], $approvalData['approved_amount']),
            'minimum_purchase' => $approvalData['minimum_purchase'],
            'maximum_purchase' => $approvalData['maximum_purchase'],
        ];

        self::signingContract($projectId);
        self::startStoreCampaign($project, $initiateCampaignData);
    }

    private static function startStoreCampaign(Project $project, $data)
    {
        $campaign = $project->campaign()->create($data)->wallet->deposit(0, ['description' => 'Initiate campaign for project']);
    }

    private static function onApprovingComitte($projectId)
    {
        $project = ProjectService::getProjectById($projectId);
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Proses Approval Komitee');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('on_approving_committee');

        self::updateProjectStatus($project, $categoryProjectSubmissionStatus);

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
        ]);
    }

    public static function acceptRevision($projectId)
    {
        $project = ProjectService::getProjectById($projectId);
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Peninjauan Proposal');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('revision_approved');

        self::updateProjectStatus($project, $categoryProjectSubmissionStatus);

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
        ]);


        self::onApprovingComitte($projectId);
    }

    public static function accept($projectId)
    {
        $project = ProjectService::getProjectById($projectId);
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Peninjauan Proposal');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('review_approved');

        self::updateProjectStatus($project, $categoryProjectSubmissionStatus);

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
        ]);

        self::onApprovingComitte($projectId);
    }

    public static function revise($projectId, $revisedProject, $supportingDocuments = null, $productCatalogs = null)
    {
        $project = ProjectService::getProjectById($projectId);
        $project->update($revisedProject);

        if ($supportingDocuments) {
            self::updateMedia($project, $supportingDocuments, 'project_supporting_documents');
        }

        if ($productCatalogs) {
            self::updateMedia($project, $productCatalogs, 'project_product_catalog');
        }

        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Peninjauan Proposal');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('revised');

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
        ]);
    }

    public static function reject($projectId, $rejectionData)
    {
        $project = ProjectService::getProjectById($projectId);
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Ditolak');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('rejected');

        self::updateProjectStatus($project, $categoryProjectSubmissionStatus);

        // handle if key 'rejection_note' is not exist in $rejectionData then create it with value $rejectionData['rejection_comittee_note']
        $rejectionData['rejection_note'] = $rejectionData['rejection_note'] ?? $rejectionData['rejection_comittee_note'];

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
            'note' => $rejectionData['rejection_note'],
        ]);
    }

    public static function addRevision($projectId, $revisionData)
    {
        $project = ProjectService::getProjectById($projectId);
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Peninjauan Proposal');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('need_revision');

        self::updateProjectStatus($project, $categoryProjectSubmissionStatus);

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
            'note' => $revisionData['revision_note'],
        ]);
    }

    public static function onReview($projectId)
    {
        $project = ProjectService::getProjectById($projectId);
        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Peninjauan Proposal');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('on_review');

        if ($project->isSubOnReview()) {
            return;
        }

        self::updateProjectStatus($project, $categoryProjectSubmissionStatus);

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
        ]);
    }

    public static function storeProject($projectData, $supportingDocuments = null, $productCatalogs = null)
    {

        $userId = auth()->user()->id;
        $project = Project::create($projectData + ['user_id' => $userId]);

        if ($supportingDocuments) {
            self::attachMediaToProject($project, $supportingDocuments, 'project_supporting_documents');
        }

        if ($productCatalogs) {
            self::attachMediaToProject($project, $productCatalogs, 'project_product_catalog');
        }

        $categoryProjectSubmissionStatus = CategoryProjectSubmissionStatusService::getCategoryByName('Proposal Project Terkirim');
        $subCategoryProjectSubmission = SubCategoryProjectSubmissionService::getSubCategoryByName('submitted');

        $project->progressStatusOfProjectSubmission()->create([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
            'sub_category_project_submission_id' => $subCategoryProjectSubmission->id,
        ]);

        return $project;
    }

    public static function updateMedia($project, $media, $collection)
    {
        $project->clearMediaCollection($collection);
        self::attachMediaToProject($project, $media, $collection);
    }

    public static function getProjectByUserId($userId)
    {
        return Project::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
    }


    public static function getProjectById($projectId)
    {
        return Project::find($projectId);
    }

    public static function ajaxDatatableByAdmin()
    {
        $query = Project::with(['category', 'user', 'categoryProjectSubmissionStatus'])->orderBy('created_at', 'desc')->get();

        return DatatableService::buildDatatable(
            $query,
            'auth.admin.project_management.action'
        );
    }

    private static function calculatePricePerUnit($offeredTokenAmount, $approvedAmount)
    {
        return $approvedAmount / $offeredTokenAmount;
    }

    private static function updateProjectStatus($project, $categoryProjectSubmissionStatus)
    {
        $project->update([
            'category_project_submission_status_id' => $categoryProjectSubmissionStatus->id,
        ]);
        $project->save();
    }


    private static function attachMediaToProject($project, $files, $collection, $isArray = true)
    {
        if ($isArray) {
            foreach ($files as $file) {
                $project->addMedia($file)->toMediaCollection($collection);
            }
        } else {
            $project->addMedia($files)->toMediaCollection($collection);
        }
    }
}
