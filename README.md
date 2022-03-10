# scout-activities
Record scout activities and display team stats

How it works

form page
- user submits form
- form data is validated
- then written in database
- then stats are updated
- the same form data is sent by email to another server as backup
- user is redirected to results page

results page
- stats are retrieved from server
- and displayed in bar chart

TODO:
- error handling


DEV NOTES:

syntax error, unexpected '=>' (T_DOUBLE_ARROW), expecting ')' in lambda

check if PHP version is at least 7.4, if not, rewrite
$job_ids = $jobs->map(fn($job) => $job->role_id)->unique();
to
$job_ids = $jobs->map(function ($job) { return $job->role_id; })->unique();
