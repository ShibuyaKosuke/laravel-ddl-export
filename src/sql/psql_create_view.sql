CREATE VIEW "constraints" AS
SELECT table_constraints.table_catalog
     , table_constraints.table_name
     , kcu.column_name                  AS "referencing_column_name"
     , ref_table_constraints.table_name AS "referenced_table_name"
     , ref_ccu.column_name              AS "referenced_column_name"
     , kcu.ordinal_position
     , table_constraints.constraint_name
FROM information_schema.table_constraints table_constraints
         INNER JOIN information_schema.key_column_usage kcu
                    ON table_constraints.constraint_catalog = kcu.constraint_catalog
                        AND table_constraints.constraint_schema = kcu.constraint_schema
                        AND table_constraints.constraint_name = kcu.constraint_name
         INNER JOIN information_schema.referential_constraints ref_con
                    ON table_constraints.constraint_catalog = ref_con.constraint_catalog
                        AND table_constraints.constraint_schema = ref_con.constraint_schema
                        AND table_constraints.constraint_name = ref_con.constraint_name
         INNER JOIN information_schema.table_constraints ref_table_constraints
                    ON ref_con.unique_constraint_catalog = ref_table_constraints.constraint_catalog
                        AND ref_con.unique_constraint_schema = ref_table_constraints.constraint_schema
                        AND ref_con.unique_constraint_name = ref_table_constraints.constraint_name
         INNER JOIN information_schema.constraint_column_usage ref_ccu
                    ON ref_table_constraints.constraint_catalog = ref_ccu.constraint_catalog
                        AND ref_table_constraints.constraint_schema = ref_ccu.constraint_schema
                        AND ref_table_constraints.constraint_name = ref_ccu.constraint_name
         INNER JOIN information_schema.key_column_usage ref_kcu
                    ON ref_table_constraints.constraint_catalog = ref_kcu.constraint_catalog
                        AND ref_table_constraints.constraint_schema = ref_kcu.constraint_schema
                        AND ref_table_constraints.constraint_name = ref_kcu.constraint_name
                        AND ref_ccu.column_name = ref_kcu.column_name
                        AND kcu.ordinal_position = ref_kcu.ordinal_position
ORDER BY table_constraints.table_catalog
       , table_constraints.table_name
       , table_constraints.constraint_name
       , kcu.ordinal_position;