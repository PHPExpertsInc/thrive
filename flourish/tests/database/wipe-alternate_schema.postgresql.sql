BEGIN;
DELETE FROM flourish2.albums;
DELETE FROM flourish2.artists;
DELETE FROM flourish2.users_groups;
DELETE FROM flourish2.groups;
DELETE FROM flourish2.users;
COMMIT;
SELECT pg_catalog.setval(pg_get_serial_sequence('flourish2.albums', 'album_id'), 1, FALSE);
SELECT pg_catalog.setval(pg_get_serial_sequence('flourish2.artists', 'artist_id'), 1, FALSE);
SELECT pg_catalog.setval(pg_get_serial_sequence('flourish2.groups', 'group_id'), 1, FALSE);
SELECT pg_catalog.setval(pg_get_serial_sequence('flourish2.users', 'user_id'), 1, FALSE);