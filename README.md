# scout-activities
Record scout activities and display team stats


hints
syntax error, unexpected '=>' (T_DOUBLE_ARROW), expecting ')' in lambda
check if PHP ersion is at least 7.4, if not, rewrite
$job_ids = $jobs->map(fn($job) => $job->role_id)->unique();
to
$job_ids = $jobs->map(function ($job) { return $job->role_id; })->unique();
