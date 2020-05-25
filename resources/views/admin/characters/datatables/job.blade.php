<div class="text-wrap">
    {{ config('constants.job.' . $model->job->JobType) }}
    <small class="text-muted">{{ $model->job->Level }} Level - Exp: {{ $model->job->Exp }}</small>
</div>
