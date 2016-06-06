# APIs

This document is all about the APIs, including available options

## Available APIs

WhiteWorks has a *lot* of endpoints, which all need to be implemented in API
controllers and models for response data. As this takes some time, this document
will keep track on the APIs that are scheduled and which of those have been
implemented.

The APIs below will be implemented before V1 is released. The items with a
checked box are implemented.

- [x]   calendaritem
  - [ ] get - *needs model*
  - [ ] getOne - *needs model*
  - [x] create
  - [x] update
  - [x] delete
- [ ]   company
- [ ]   contact
- [ ]   contract
- [ ]   contractline
- [ ]   costheading
- [ ]   employee
- [ ]   employeefamily
- [ ]   filete
- [ ]   hourte
- [ ]   invoice
- [ ]   invoiceline
- [ ]   offere
- [ ]   offerphase
- [ ]   offerprojectline
- [ ]   payment
- [ ]   product
- [ ]   project
- [ ]   projectphase
- [ ]   purchaseinvoice
- [ ]   purchaseinvoiceline
- [ ]   purchasepayment
- [ ]   tag
- [ ]   task
- [ ]   taskphase
- [ ]   timelineentry
- [ ]   unit

## Options per API

You'll want to use <kbd>Ctrl</kbd> + <kbd>F</kbd> as this list grows. Note that
not all items are always required, but they're not always clearly documented by
the WhiteWorks doc. Some trial-and-error should give clear results (please
report them!).

All items that expect an ISO 8601 date or time also accept `DateTime` objects,
which will be put in the right format. Timezones will be changed to UTC.

### calendaritem
#### get, getOne

`get(array $filters, array $options = [])`
`getOne(array $filters, array $options = [])`

- **$filters**: Filters to apply, list of `Schakel\WhiteWorks\ApiFilter` objects.
- **$options**: Extra options, such as paging and sorting.

<!-- TODO -->

#### create, update

`create(array $fields)`
`update($id, array $fields)`

- **$id**: ID of the object to change
- **$fields**: Fields to set / update, see below.

Available fields for *calendaritem*:
- `_ordering` - Where to order (optional)
- `date` - Date of the calendar item, as [ISO 8601 date][8601-date].
- `hours` - Duration of the calendar item, in hours (decimal)
- `calendaritememployee` - Id of the employee associated with this item
- `completedon` - Date of completion, as [ISO 8601 date][8601-date].
- `time` - Time the calendar item starts, as [ISO 8601 time][8601-time].
- `timelineentry` - Entry in the timeline
- `task` - ID of the associated task

#### delete

`delete($id)`

- **$id**: ID of the object to change



[8601-date]: https://en.wikipedia.org/wiki/ISO_8601#Calendar_dates
[8601-time]: https://en.wikipedia.org/wiki/ISO_8601#Times
[8601]: https://en.wikipedia.org/wiki/ISO_8601
