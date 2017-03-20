Really simple spotify activity tracker to determine if someone is in the den or not.

1. Connect to last.fm and pull the current playing song.
2. Check the last known status (active or not) recorded. (this status represents whether someone is in the den)
3. If the status has changed since last recorded, send curl request to slack webhook.