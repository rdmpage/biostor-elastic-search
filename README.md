# biostor-elastic-search
Elastic search of BioStor content

## Model

We can model a BioStor work (e.g., and article) and its pages as parent and children.

## Mapping

We need to create a mapping between parent and child when we create the index.

```javascript
{
	"page": {
		"_parent": {
			"type": "work"
		}
	}
}
```

## Adding data

We first add a work, then we add it’s pages, and we need to link the two.

$biostor = 146658;

$elastic->send('PUT', 'work/' . $biostor, json_encode($obj));

$elastic->send('PUT', 'page/' . $PageID . '?parent=' . $biostor, json_encode($page));


## Searches

### Searching for works

#### Searching within work metadata

POST /elasticsearch/biostor/work/_search

```javascript
{
  "query": {
        "match": {
           "author.family": "Warren"
			}
    }
}
```

#### Searching within text
Here we search the OCR text of the child pages and return a list of works. Note the use of "**score_mode" : "sum**" to get scores, and that we are searching the **work** index. This gives us a list of works, ordered by how well their OCR text matches the query.

POST /elasticsearch/biostor/work/_search

```javascript
{
	"query":{
		"has_child": {
			"type":"page",
 			"score_mode" : "sum",
    	"query": {
        		"match": {
           			"OcrText": "Epiplema"
					}
    	}
		}
	}
}
```

### Searching for pages matching text

We can search pages for text, and highlight the hits (note use of **page** index).

POST /elasticsearch/biostor/page/_search

```javascript
{
	"query": {
			"match": {
				"OcrText": "Epiplema arcuata"
			}
    },
	"highlight": {
       "fields" : {
          "OcrText" : {}
       }
    }
}
```

### Searching for pages matching text within a work

POST /elasticsearch/biostor/page/_search

```javascript
{
	"query": {
		"bool": {
			"must": {
				"terms": {
					"_parent": ["60645"]
				}
			},
			"should": [{
				"match": {
					"OcrText": "Epiplema arcuata"
				}
			}]
		}
	},
	"highlight": {
		"fields": {
			"OcrText": {}
		}
	}
}
```

