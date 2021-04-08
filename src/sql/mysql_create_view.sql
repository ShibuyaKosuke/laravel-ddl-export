CREATE VIEW `constraints` AS
SELECT usg.table_schema           as table_catalog,
       usg.table_name             as table_name,
       usg.column_name            as referencing_column_name,
       usg.REFERENCED_TABLE_NAME  as referenced_table_name,
       usg.ORDINAL_POSITION       as ordinal_position,
       usg.REFERENCED_COLUMN_NAME as referenced_column_name,
       cst.constraint_name        as constraint_name
FROM information_schema.key_column_usage usg
         LEFT JOIN information_schema.table_constraints cst
                   ON usg.table_schema = cst.table_schema
                       AND usg.constraint_name = cst.constraint_name
WHERE cst.constraint_type = 'FOREIGN KEY'
  and usg.table_schema = 'bizocean_portal'