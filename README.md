# Status-Page
I created this public website to display the status of our websites and services to our customers. This website is built using PHP, CSS and HTML.

Notes:
- This page was tested on Ubuntu 20.04 and 22.04 using Nginx as a webserver.
- This page was hosted behind an AWS Application Load Balalncer and using Amazon SSL Certs for HTTPS traffic

Functionality
- The page will refresh the data every 30 seconds
- The status of the services are imported from Datadog Monitors
- The page uses RSS by Zapier for the RSS feed subscriptions
- The page uses Slack API to display the team updates (Slack Channel -> Slack App -> Status Page)