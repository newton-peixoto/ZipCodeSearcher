# Php ZipCodeSearcher

You will be able to get information about zipCode by instantiate your searcher.


## 🚀 Getting Started

### Prerequisites

`composer` 

`php 7.0 >=`

### 🔃 Installing

run
```
composer require newtz/zipcode
```

After that just import the class ZipCode

```
use ZipCode\ZipCode;
```

### ✅  Usage

`ZipCode::getSearcher()` expects a country abbreviation. If none is passed it will search in Brazil.

`$searcher= ZipCode::getSearcher('US');`

`$searcher->find('90210');`

 `echo $searcher->address;`

 `output: Beverly Hills - California. 34.0901, -118.4065.`

`$searcher->address->street` - available to Brazil searches otherwise is `null`

`$searcher->address->state` - available in all searches

`$searcher->address->city` - available in all searches

`$searcher->address->neighborhood` - available in Brazil searches otherwise is `null`

`$searcher->address->latitude` - available in WorldWide searches otherwise is `null`

`$searcher->address->longitude` - available in WorldWide searches otherwise is `null`

## 🤔 Contributing

> To get started...

### Step 1

- 🍴 Fork this repo!

### Step 2

- 👯 Clone this repo to your local machine using `https://github.com/Newtz/ZipCodeSearcher`

### Step 3

- 🎋 Create your feature branch using `git checkout -b my-feature`

### Step 4

- ✅ Commit your changes using `git commit -m 'feat: My new feature'`;

### Step 5

- 📌 Push to the branch using `git push origin my-feature`;

### Step 6

- 🔃 Create a new pull request

After your Pull Request is merged, can you delete your feature branch.

---


### ✅  Tests

To run the tests execute the command 

`./vendor/bin/phpunit --process-isolation`

## Authors

* **Newton Peixoto** - *Initial work* - [github](https://github.com/Newtz)

* **Breno Augusto** - *Initial work* - [github](https://github.com/breno23augusto)

## License

This project is licensed under the MIT License
