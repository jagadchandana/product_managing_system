UPDATE test t
JOIN test_audit ta ON t.id = ta.id
SET t.REPORT_TO = ta.REPORT_TO
WHERE t.REPORT_TO = '' OR t.REPORT_TO IS NULL;