MongoDB commands:

```sql
use test
show collections
db.events.find()
```
GraphiQL Query example:

```graphql
{
  account(id: "d57ff9af-cc59-4cd0-9aeb-853bddef3439") {
    name,
    currency,
    balance
  }
}

```

GraphiQL Mutation example:

```graphql
mutation {
  createAccount(input:{accountName: "Name5", accountCurrency: "pln"}) {
    id
    name
    currency
  }
}
```
