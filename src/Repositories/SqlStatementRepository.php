<?php

/**
 * TechDivision\Import\Ee\Repositories\SqlStatementRepository
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-ee
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Ee\Repositories;

use TechDivision\Import\Ee\Utils\SqlStatementKeys;

/**
 * Utility class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-ee
 * @link      http://www.techdivision.com
 */
class SqlStatementRepository extends \TechDivision\Import\Repositories\SqlStatementRepository
{

    /**
     * The SQL statements.
     *
     * @var array
     */
    private $statements = array(
        SqlStatementKeys::CATEGORIES =>
            'SELECT t0.*,
                    (SELECT `value`
                       FROM ${table:eav_attribute} t1, ${table:catalog_category_entity_varchar} t2
                      WHERE t1.attribute_code = \'name\'
                        AND t1.entity_type_id = 3
                        AND t2.attribute_id = t1.attribute_id
                        AND t2.store_id = 0
                        AND t2.row_id = t0.row_id) AS name,
                    (SELECT `value`
                       FROM ${table:eav_attribute} t1, ${table:catalog_category_entity_varchar} t2
                      WHERE t1.attribute_code = \'url_key\'
                        AND t1.entity_type_id = 3
                        AND t2.attribute_id = t1.attribute_id
                        AND t2.store_id = 0
                        AND t2.row_id = t0.row_id) AS url_key,
                    (SELECT `value`
                       FROM ${table:eav_attribute t1}, ${table:catalog_category_entity_varchar} t2
                      WHERE t1.attribute_code = \'url_path\'
                        AND t1.entity_type_id = 3
                        AND t2.attribute_id = t1.attribute_id
                        AND t2.store_id = 0
                        AND t2.row_id = t0.row_id) AS url_path,
                    (SELECT `value`
                       FROM ${table:eav_attribute} t1, ${table:catalog_category_entity_int} t2
                      WHERE t1.attribute_code = \'is_anchor\'
                        AND t1.entity_type_id = 3
                        AND t2.attribute_id = t1.attribute_id
                        AND t2.store_id = 0
                        AND t2.row_id = t0.row_id) AS is_anchor
               FROM ${table:catalog_category_entity} AS t0',
        SqlStatementKeys::CATEGORIES_BY_STORE_VIEW =>
            'SELECT t0.*,
                 IF (name_store.value_id > 0, name_store.value, name_default.value) AS name,
                 IF (url_key_store.value_id > 0, url_key_store.value, url_key_default.value) AS url_key,
                 IF (url_path_store.value_id > 0, url_path_store.value, url_path_default.value) AS url_path,
                 IF (is_anchor_store.value_id > 0, is_anchor_store.value, is_anchor_default.value) AS is_anchor
               FROM ${table:catalog_category_entity} AS t0
          LEFT JOIN ${table:catalog_category_entity_varchar} AS name_store
                 ON name_store.attribute_id = (
                        SELECT attribute_id FROM ${table:eav_attribute}
                        WHERE attribute_code = \'name\' AND entity_type_id = 3
                    )
                    AND name_store.store_id = :store_id
                    AND name_store.row_id = t0.row_id
          LEFT JOIN ${table:catalog_category_entity_varchar} AS name_default
                 ON name_default.attribute_id = (
                        SELECT attribute_id FROM ${table:eav_attribute}
                        WHERE attribute_code = \'name\' AND entity_type_id = 3
                    )
                    AND name_default.store_id = 0
                    AND name_default.row_id = t0.row_id
          LEFT JOIN ${table:catalog_category_entity_varchar} AS url_key_store
                 ON url_key_store.attribute_id = (
                        SELECT attribute_id FROM ${table:eav_attribute}
                        WHERE attribute_code = \'url_key\' AND entity_type_id = 3
                    )
                    AND url_key_store.store_id = :store_id
                    AND url_key_store.row_id = t0.row_id
          LEFT JOIN ${table:catalog_category_entity_varchar} AS url_key_default
                 ON url_key_default.attribute_id = (
                        SELECT attribute_id FROM ${table:eav_attribute}
                        WHERE attribute_code = \'url_key\' AND entity_type_id = 3
                    )
                    AND url_key_default.store_id = 0
                    AND url_key_default.row_id = t0.row_id
          LEFT JOIN ${table:catalog_category_entity_varchar} AS url_path_store
                 ON url_path_store.attribute_id = (
                        SELECT attribute_id FROM ${table:eav_attribute}
                        WHERE attribute_code = \'url_path\' AND entity_type_id = 3
                    )
                    AND url_path_store.store_id = :store_id
                    AND url_path_store.row_id = t0.row_id
          LEFT JOIN ${table:catalog_category_entity_varchar} AS url_path_default
                 ON url_path_default.attribute_id = (
                        SELECT attribute_id FROM ${table:eav_attribute}
                        WHERE attribute_code = \'url_path\' AND entity_type_id = 3
                    )
                    AND url_path_default.store_id = 0
                    AND url_path_default.row_id = t0.row_id
          LEFT JOIN ${table:catalog_category_entity_int} AS is_anchor_store
                 ON is_anchor_store.attribute_id = (
                        SELECT attribute_id FROM ${table:eav_attribute}
                        WHERE attribute_code = \'is_anchor\' AND entity_type_id = 3
                    )
                    AND is_anchor_store.store_id = :store_id
                    AND is_anchor_store.row_id = t0.row_id
          LEFT JOIN ${table:catalog_category_entity_int} AS is_anchor_default
                 ON is_anchor_default.attribute_id = (
                        SELECT attribute_id FROM ${table:eav_attribute}
                        WHERE attribute_code = \'is_anchor\' AND entity_type_id = 3
                    )
                    AND is_anchor_default.store_id = 0
                    AND is_anchor_default.row_id = t0.row_id',
        SqlStatementKeys::CATEGORY_VARCHARS_BY_ENTITY_IDS =>
            'SELECT t1.*
               FROM ${table:catalog_category_entity} AS t0
         INNER JOIN ${table:catalog_category_entity_varchar} AS t1
                 ON t1.row_id = t0.row_id
         INNER JOIN ${table:eav_attribute} AS t2
                 ON t2.entity_type_id = 3
                AND t2.attribute_code = \'name\'
                AND t1.attribute_id = t2.attribute_id
                AND t1.store_id = 0
                AND t0.entity_id IN (?)'
    );

    /**
     * Initializes the SQL statement repository with the primary key and table prefix utility.
     *
     * @param \IteratorAggregate<\TechDivision\Import\Utils\SqlCompilerInterface> $compilers The array with the compiler instances
     */
    public function __construct(\IteratorAggregate $compilers)
    {

        // pass primary key + table prefix utility to parent instance
        parent::__construct($compilers);

        // compile the SQL statements
        $this->compile($this->statements);
    }
}
