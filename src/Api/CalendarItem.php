<?php
/**
 * Part of Schakel Marketeers WhiteWorks API
 *
 * @license GPL-v3
 * @link https://github.com/SchakelMarketeers/WhiteWorks-API
 */

namespace Schakel\WhiteWorks\Api;

use Schakel\WhiteWorks\Client;
use Schakel\WhiteWorks\ApiFilter;

/**
 * Describes an API object, which always has the following methods.
 *
 * Optionally extra methods may exist for certain APIs, but they're limited.
 *
 * @author Roelof Roos <roelof@schakelmarketeers.nl>
 */
class CalendarItem extends ApiNodeAbstract
{
    /**
     * Retrieves /all/ calendar items.
     *
     * {@inheritdoc}
     */
    public function get(array $filters, array $options = [])
    {
        return $this->apiCall('calendaritem.get', [
            self::buildFilter($filters),
            $options
        ]);
    }
    /**
     * Retrieves a single calendar items.
     *
     * {@inheritdoc}
     */
    public function getOne(array $filters, array $options = [])
    {
        return $this->apiCall('calendaritem.getone', [
            self::buildFilter($filters),
            $options
        ]);
    }

    /**
     * Updates a calendar item.
     *
     * {@inheritdoc}
     */
    public function update($id, array $fields = [])
    {
        $valid = [
            "_ordering", "date", "hours",
            "calendaritememployee",
            "completedon", "time",
            "timelineentry", "task"
        ];

        $data = array_intersect_key($fields, $valid);

        if (empty($data)) {
            throw new \UnexpectedValueException('Expected $fields to contain data, but it\'s empty.');
        }

        return $this->apiCall('calendaritem.update', [$id, $fields]);
    }

    /**
     * Creates a new calendar item.
     *
     * {@inheritdoc}
     */
    public function create(array $fields = [])
    {
        $valid = [
            "_ordering", "date", "hours",
            "calendaritememployee",
            "completedon", "time",
            "timelineentry", "task"
        ];

        $data = array_intersect_key($fields, $valid);

        if (empty($data)) {
            throw new \UnexpectedValueException('Expected $fields to contain data, but it\'s empty.');
        }

        return $this->apiCall('calendaritem.create', [$data]);
    }

    /**
     * Deletes a calendar item
     * {@inheritdoc}
     */
    public function delete($id)
    {
        return $this->apiCall('calendaritem.delete', [$id]);
    }
}
