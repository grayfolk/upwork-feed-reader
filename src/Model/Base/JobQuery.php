<?php

namespace App\Model\Base;

use \Exception;
use \PDO;
use App\Model\Job as ChildJob;
use App\Model\JobQuery as ChildJobQuery;
use App\Model\Map\JobTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'job' table.
 *
 *
 *
 * @method     ChildJobQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildJobQuery orderByLink($order = Criteria::ASC) Order by the link column
 * @method     ChildJobQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildJobQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildJobQuery orderByBudget($order = Criteria::ASC) Order by the budget column
 * @method     ChildJobQuery orderByCategory($order = Criteria::ASC) Order by the category column
 * @method     ChildJobQuery orderByCountry($order = Criteria::ASC) Order by the country column
 * @method     ChildJobQuery orderByIsDeleted($order = Criteria::ASC) Order by the is_deleted column
 * @method     ChildJobQuery orderByIsSaved($order = Criteria::ASC) Order by the is_saved column
 * @method     ChildJobQuery orderByPosted($order = Criteria::ASC) Order by the posted column
 *
 * @method     ChildJobQuery groupById() Group by the id column
 * @method     ChildJobQuery groupByLink() Group by the link column
 * @method     ChildJobQuery groupByTitle() Group by the title column
 * @method     ChildJobQuery groupByDescription() Group by the description column
 * @method     ChildJobQuery groupByBudget() Group by the budget column
 * @method     ChildJobQuery groupByCategory() Group by the category column
 * @method     ChildJobQuery groupByCountry() Group by the country column
 * @method     ChildJobQuery groupByIsDeleted() Group by the is_deleted column
 * @method     ChildJobQuery groupByIsSaved() Group by the is_saved column
 * @method     ChildJobQuery groupByPosted() Group by the posted column
 *
 * @method     ChildJobQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildJobQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildJobQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildJobQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildJobQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildJobQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildJobQuery leftJoinJobSkill($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobSkill relation
 * @method     ChildJobQuery rightJoinJobSkill($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobSkill relation
 * @method     ChildJobQuery innerJoinJobSkill($relationAlias = null) Adds a INNER JOIN clause to the query using the JobSkill relation
 *
 * @method     ChildJobQuery joinWithJobSkill($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the JobSkill relation
 *
 * @method     ChildJobQuery leftJoinWithJobSkill() Adds a LEFT JOIN clause and with to the query using the JobSkill relation
 * @method     ChildJobQuery rightJoinWithJobSkill() Adds a RIGHT JOIN clause and with to the query using the JobSkill relation
 * @method     ChildJobQuery innerJoinWithJobSkill() Adds a INNER JOIN clause and with to the query using the JobSkill relation
 *
 * @method     \App\Model\JobSkillQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildJob findOne(ConnectionInterface $con = null) Return the first ChildJob matching the query
 * @method     ChildJob findOneOrCreate(ConnectionInterface $con = null) Return the first ChildJob matching the query, or a new ChildJob object populated from the query conditions when no match is found
 *
 * @method     ChildJob findOneById(int $id) Return the first ChildJob filtered by the id column
 * @method     ChildJob findOneByLink(string $link) Return the first ChildJob filtered by the link column
 * @method     ChildJob findOneByTitle(string $title) Return the first ChildJob filtered by the title column
 * @method     ChildJob findOneByDescription(string $description) Return the first ChildJob filtered by the description column
 * @method     ChildJob findOneByBudget(int $budget) Return the first ChildJob filtered by the budget column
 * @method     ChildJob findOneByCategory(string $category) Return the first ChildJob filtered by the category column
 * @method     ChildJob findOneByCountry(string $country) Return the first ChildJob filtered by the country column
 * @method     ChildJob findOneByIsDeleted(boolean $is_deleted) Return the first ChildJob filtered by the is_deleted column
 * @method     ChildJob findOneByIsSaved(boolean $is_saved) Return the first ChildJob filtered by the is_saved column
 * @method     ChildJob findOneByPosted(string $posted) Return the first ChildJob filtered by the posted column *

 * @method     ChildJob requirePk($key, ConnectionInterface $con = null) Return the ChildJob by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJob requireOne(ConnectionInterface $con = null) Return the first ChildJob matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJob requireOneById(int $id) Return the first ChildJob filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJob requireOneByLink(string $link) Return the first ChildJob filtered by the link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJob requireOneByTitle(string $title) Return the first ChildJob filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJob requireOneByDescription(string $description) Return the first ChildJob filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJob requireOneByBudget(int $budget) Return the first ChildJob filtered by the budget column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJob requireOneByCategory(string $category) Return the first ChildJob filtered by the category column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJob requireOneByCountry(string $country) Return the first ChildJob filtered by the country column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJob requireOneByIsDeleted(boolean $is_deleted) Return the first ChildJob filtered by the is_deleted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJob requireOneByIsSaved(boolean $is_saved) Return the first ChildJob filtered by the is_saved column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildJob requireOneByPosted(string $posted) Return the first ChildJob filtered by the posted column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildJob[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildJob objects based on current ModelCriteria
 * @method     ChildJob[]|ObjectCollection findById(int $id) Return ChildJob objects filtered by the id column
 * @method     ChildJob[]|ObjectCollection findByLink(string $link) Return ChildJob objects filtered by the link column
 * @method     ChildJob[]|ObjectCollection findByTitle(string $title) Return ChildJob objects filtered by the title column
 * @method     ChildJob[]|ObjectCollection findByDescription(string $description) Return ChildJob objects filtered by the description column
 * @method     ChildJob[]|ObjectCollection findByBudget(int $budget) Return ChildJob objects filtered by the budget column
 * @method     ChildJob[]|ObjectCollection findByCategory(string $category) Return ChildJob objects filtered by the category column
 * @method     ChildJob[]|ObjectCollection findByCountry(string $country) Return ChildJob objects filtered by the country column
 * @method     ChildJob[]|ObjectCollection findByIsDeleted(boolean $is_deleted) Return ChildJob objects filtered by the is_deleted column
 * @method     ChildJob[]|ObjectCollection findByIsSaved(boolean $is_saved) Return ChildJob objects filtered by the is_saved column
 * @method     ChildJob[]|ObjectCollection findByPosted(string $posted) Return ChildJob objects filtered by the posted column
 * @method     ChildJob[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class JobQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Model\Base\JobQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Model\\Job', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildJobQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildJobQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildJobQuery) {
            return $criteria;
        }
        $query = new ChildJobQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildJob|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(JobTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = JobTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildJob A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, link, title, description, budget, category, country, is_deleted, is_saved, posted FROM job WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildJob $obj */
            $obj = new ChildJob();
            $obj->hydrate($row);
            JobTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildJob|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JobTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JobTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JobTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JobTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the link column
     *
     * Example usage:
     * <code>
     * $query->filterByLink('fooValue');   // WHERE link = 'fooValue'
     * $query->filterByLink('%fooValue%', Criteria::LIKE); // WHERE link LIKE '%fooValue%'
     * </code>
     *
     * @param     string $link The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobTableMap::COL_LINK, $link, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%', Criteria::LIKE); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the budget column
     *
     * Example usage:
     * <code>
     * $query->filterByBudget(1234); // WHERE budget = 1234
     * $query->filterByBudget(array(12, 34)); // WHERE budget IN (12, 34)
     * $query->filterByBudget(array('min' => 12)); // WHERE budget > 12
     * </code>
     *
     * @param     mixed $budget The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function filterByBudget($budget = null, $comparison = null)
    {
        if (is_array($budget)) {
            $useMinMax = false;
            if (isset($budget['min'])) {
                $this->addUsingAlias(JobTableMap::COL_BUDGET, $budget['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($budget['max'])) {
                $this->addUsingAlias(JobTableMap::COL_BUDGET, $budget['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobTableMap::COL_BUDGET, $budget, $comparison);
    }

    /**
     * Filter the query on the category column
     *
     * Example usage:
     * <code>
     * $query->filterByCategory('fooValue');   // WHERE category = 'fooValue'
     * $query->filterByCategory('%fooValue%', Criteria::LIKE); // WHERE category LIKE '%fooValue%'
     * </code>
     *
     * @param     string $category The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function filterByCategory($category = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($category)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobTableMap::COL_CATEGORY, $category, $comparison);
    }

    /**
     * Filter the query on the country column
     *
     * Example usage:
     * <code>
     * $query->filterByCountry('fooValue');   // WHERE country = 'fooValue'
     * $query->filterByCountry('%fooValue%', Criteria::LIKE); // WHERE country LIKE '%fooValue%'
     * </code>
     *
     * @param     string $country The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function filterByCountry($country = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($country)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobTableMap::COL_COUNTRY, $country, $comparison);
    }

    /**
     * Filter the query on the is_deleted column
     *
     * Example usage:
     * <code>
     * $query->filterByIsDeleted(true); // WHERE is_deleted = true
     * $query->filterByIsDeleted('yes'); // WHERE is_deleted = true
     * </code>
     *
     * @param     boolean|string $isDeleted The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function filterByIsDeleted($isDeleted = null, $comparison = null)
    {
        if (is_string($isDeleted)) {
            $isDeleted = in_array(strtolower($isDeleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobTableMap::COL_IS_DELETED, $isDeleted, $comparison);
    }

    /**
     * Filter the query on the is_saved column
     *
     * Example usage:
     * <code>
     * $query->filterByIsSaved(true); // WHERE is_saved = true
     * $query->filterByIsSaved('yes'); // WHERE is_saved = true
     * </code>
     *
     * @param     boolean|string $isSaved The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function filterByIsSaved($isSaved = null, $comparison = null)
    {
        if (is_string($isSaved)) {
            $isSaved = in_array(strtolower($isSaved), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobTableMap::COL_IS_SAVED, $isSaved, $comparison);
    }

    /**
     * Filter the query on the posted column
     *
     * Example usage:
     * <code>
     * $query->filterByPosted('2011-03-14'); // WHERE posted = '2011-03-14'
     * $query->filterByPosted('now'); // WHERE posted = '2011-03-14'
     * $query->filterByPosted(array('max' => 'yesterday')); // WHERE posted > '2011-03-13'
     * </code>
     *
     * @param     mixed $posted The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function filterByPosted($posted = null, $comparison = null)
    {
        if (is_array($posted)) {
            $useMinMax = false;
            if (isset($posted['min'])) {
                $this->addUsingAlias(JobTableMap::COL_POSTED, $posted['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($posted['max'])) {
                $this->addUsingAlias(JobTableMap::COL_POSTED, $posted['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobTableMap::COL_POSTED, $posted, $comparison);
    }

    /**
     * Filter the query by a related \App\Model\JobSkill object
     *
     * @param \App\Model\JobSkill|ObjectCollection $jobSkill the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildJobQuery The current query, for fluid interface
     */
    public function filterByJobSkill($jobSkill, $comparison = null)
    {
        if ($jobSkill instanceof \App\Model\JobSkill) {
            return $this
                ->addUsingAlias(JobTableMap::COL_ID, $jobSkill->getJobId(), $comparison);
        } elseif ($jobSkill instanceof ObjectCollection) {
            return $this
                ->useJobSkillQuery()
                ->filterByPrimaryKeys($jobSkill->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJobSkill() only accepts arguments of type \App\Model\JobSkill or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobSkill relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function joinJobSkill($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobSkill');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'JobSkill');
        }

        return $this;
    }

    /**
     * Use the JobSkill relation JobSkill object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Model\JobSkillQuery A secondary query class using the current class as primary query
     */
    public function useJobSkillQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobSkill($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobSkill', '\App\Model\JobSkillQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildJob $job Object to remove from the list of results
     *
     * @return $this|ChildJobQuery The current query, for fluid interface
     */
    public function prune($job = null)
    {
        if ($job) {
            $this->addUsingAlias(JobTableMap::COL_ID, $job->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the job table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JobTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            JobTableMap::clearInstancePool();
            JobTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(JobTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(JobTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            JobTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            JobTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // JobQuery
