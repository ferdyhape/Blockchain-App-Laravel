<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategoryProjectSubmission extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Metode mutator untuk menghasilkan keterangan berdasarkan nama sub status
    public function getNoteByNameAttribute()
    {
        switch ($this->name) {
                // sub status dari 'Proposal Project Terkirim',
            case 'submitted':
                return 'Proposal project Anda berhasil terkirim dan akan diperiksa oleh Tim Kami';
                // sub status dari 'Peninjauan Proposal',
            case 'on_review':
                return 'Proposal project Anda sedang dalam tahap peninjauan oleh Tim Kami';
            case 'need_revision':
                return 'Proposal project Anda memerlukan revisi';
            case 'revised':
                return 'Proposal project Anda sudah direvisi';
            case 'revision_approved':
                return 'Proposal project Anda sudah direvisi dan disetujui';
            case 'review_approved':
                return 'Proposal project Anda sudah disetujui';
                // sub status dari 'Proses Approval Komitee',
            case 'on_approving_committee':
                return 'Proposal project Anda sedang dalam tahap persetujuan oleh Komite';
            case 'approved_by_committee':
                return 'Proposal project Anda sudah disetujui oleh Komite';
            case 'rejected_by_committee':
                return 'Proposal project Anda ditolak oleh Komite';
                // sub status dari 'Proses Tanda Tangan Kontrak',
            case 'on_contract_signing':
                return 'Proposal project Anda sedang dalam tahap penandatanganan kontrak';
            case 'contract_signed':
                return 'Kontrak project Anda sudah ditandatangani';
                // sub status dari 'Proses Persetujuan Tanda Tangan Kontrak',
            case 'contract_signed_accepted':
                return 'Kontrak project Anda sudah ditandatangani dan disetujui';
            case 'contract_signed_need_revision':
                return 'Kontrak project Anda memerlukan revisi';
                // sub status dari 'Proses Penggalangan Dana',
            case 'on_fundraising':
                return 'Proposal project Anda sedang dalam tahap penggalangan dana';
            case 'on_going':
                return 'Projek Sedang Berjalan';
            case 'closed':
                return 'Projek Selesai';
            case 'cancelled':
                return 'Proposal project Anda dibatalkan';
                // default
            default:
                return '-';
        }
    }

    protected static function booted()
    {
        static::saving(function ($progressStatus) {
            $progressStatus->notes = $progressStatus->noteByName;
        });
    }

    public function categoryProjectSubmissionStatus()
    {
        return $this->belongsTo(CategoryProjectSubmissionStatus::class, 'category_project_submission_status_id', 'id');
    }
}
