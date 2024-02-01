This is an Admin feature called "Scorecard"

Here is the story and plan for this update: SEPARATE functionality that's similar to Objectives called "Scorecards"

*** A scorecard IS a KPI.

*** Each scorecard is attached to 1 user and they report on that for each duration.

*** Report means Via email and on the dashboard

*** They have to 'execute' the Scorecard weekly recurring

***so if the Scorecard was "$100 revenue weekly" and assigned to you. every friday, you would have to enter in the Scorecard value (revenue). it's recurring EVERY week (or month or quarter, duration)

*** they get reminders if not updated.

*** the scorecard is recurring forever possibly

*** KPI metric is just a text field.

1) ScoreCard data will integrate (new row) into the Dashboard view as consolidated ScoreCards (KPIs_ and Objectives)

2) new Side nav for ScoreCard (similar to objectives link)

3) Create new ScoreCard:

4) All ScoreCard Items elements are TEAM oriented (ie. emulate the Team Objective layout), and you associate individuals that are responsible for Updating that KPI each and every "duration" (week, month, year, quarter,etc). These rarely change and we used to track progress for the duration over a long period of time.

5). a ScoreCard item includes this:
a) Title                        [x]       
b) Description                  [x] 
c) KPI metric                   [x] 
d) team member responsibility for updating [x] 
e) duration of ScoreCard reporting (weekly, monthly, quarterly, bi-weekly, etc) [x]
f) Associate any number of users that are responsible for entering in the KPI every "duration"

What will happen is an admin will setup a new ScoreCard (KPI): "Revenue of $800 every week" and assign it to 1 or more users. Then EVERY week (same as objective execute and due date) they get a reminder and have to enter in that Value. these ScoreCard items NEVER expire and are recurring every week. The end result is that the ADMIN can see weekly progress over time for that team, and see how accurate they are at hittling long term goals (KPIs or scorecards).



-----------------------------------------------------------------------

The confusion is the auto-creation of the Personal Team. we need to handle this differently. 1) when user is invited and setups new account they ONLY have the team account they were invited to. this needs to be their default team unless they CREATE or are invited to another. 2). Let's put the PERSONAL TEAM option OUT of the top right nav and put it in the bottom of the left nave. 3) the problem is that people are creating objectives in their personal team (instead of the only team they were invited to) because they didn't even know they HAD a personal team. ok??

------------------------------------------------------------------------


We are also having trouble with people accepting invites and having the teams loaded on their P&E".
 In particular if you can look at. Tim Aldrich and Nicole Lukenoff

----------------------------------------------------------------------
also, i think for USERS we need a separate page/area for Completed Objectives. only show NON-completed (or missed) objectives to them

then have a separate ARCHIVE type page that shows Completed and Missed objectives


-----------------------------------------------------------------

He missed this objective, from this view I want to see misses as red and completed as green. 
I also want to see the persons execution % listed with some kind of user title. 
The initials will not work with a large team


we really need the MISS objective and show it in RED

His miss should be signified in the dark great bar above for example 3/4

---------------------------------------------------------------------

We need to improve the email notifications as well. It needs a redesign with color and a quote about doing what the user said they were going to do.

there are too many MISSES that look like MAKES (completed)

I like this box. We should be able to do something with it. I want to be able to click it and see a description and ask a questions.

------------------------------------------------------------------------








ALTER TABLE `scorecards`  ADD `completed` BOOLEAN NULL DEFAULT NULL  AFTER `kpi_metric`;
ALTER TABLE `scorecard_histories` CHANGE `note` `note` VARCHAR(255) NULL DEFAULT NULL;

ALTER TABLE `objectives`  ADD `deleted_at` TIMESTAMP NULL DEFAULT NULL  AFTER `completed_at`;
ALTER TABLE `key_results`  ADD `deleted_at` TIMESTAMP NULL DEFAULT NULL  AFTER `due_date`;


