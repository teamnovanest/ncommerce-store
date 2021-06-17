(function () {
 

/*   const search = instantsearch({
    indexName: 'instant_search',
    searchClient: algoliasearch(
      'NPLVI1F6D8',
      '00702f144eb02973f80ff12f5f8cac7a'
    ),
  });
  
  // Add widgets
  // ...
  
  search.start();
  
 */

    var searchClient = algoliasearch('NPLVI1F6D8', '00702f144eb02973f80ff12f5f8cac7a');
    //var index = searchClient.initIndex('product_idx');
    const search = instantsearch({
        indexName: 'dev_VESTASHI',
        searchClient,
    });

    // Search for a first name
  

    search.addWidgets([
        instantsearch.widgets.configure({
            hitsPerPage: 10,
        }),
      
        instantsearch.widgets.searchBox({
          container: '#searchbox',
          placeholder: 'Search for items on our site',
        }),
        instantsearch.widgets.hits({
            container: '#hits',
            templates: {
              item: document.getElementById('hit-template').innerHTML,
              empty: `We didn't find any results for the search <em>"{{query}}"</em>`,
            },
          }),
          instantsearch.widgets.pagination({
            container: '#pagination'
          })

      ]);

      search.start();

/*   var searchBoxElm = document.querySelector('#searchbox');
  searchBoxElm.addEventListener('keyup',function(evt) {
  
    index.search(evt.target.value).then(({ hits }) => {
        console.log(evt.target.value);
        console.log(hits);
        
      });
      
  }); */
/* 
    search.addWidgets([
        instantsearch.widgets.configure({
            hitsPerPage: 10,
        })
    ]);

    search.addWidgets([
        instantsearch.widgets.searchBox({
          container: '#searchbox',
          placeholder: 'Search for contacts',
        })
      ]);

      search.addWidgets([
        instantsearch.widgets.hits({
          container: '#hits',
          templates: {
            item: `
            <div class="hit">
              <p class="hit-name">
                {{#helpers.highlight}}{ "attribute": "product_name" }{{/helpers.highlight}}
               
              </p>
            </div>
        `,
            empty: `We didn't find any results for the search <em>"{{query}}"</em>`,
          },
        })
      ])

    var searchBoxElm = document.querySelector('#searchbox');
    searchBoxElm.addEventListener('change',function(evt) {
        console.log(evt);
        
    });
   
    search.start(); */
    //   instantsearch.widgets.autocomplete({container:'#searchbox',
    //   placeholder: 'Search for products',

    //   });

    /*
    
          {
              source: instantsearch.widgets.autocomplete.sources.hints(search, {hitsPerpage: 10 }),
              displayKey: 'product_name',
              templates:{
                  suggestion: function(suggestion){
                    return '<span>' +
    
    
                    suggestion._highlightResult.product_name.value
                    +'</span>'
                  }
              }
    
     instantsearch.widgets.clearRefinements({
          container: '#clear-refinements',
        }),
        instantsearch.widgets.refinementList({
          container: '#brand-list',
          attribute: 'brand',
        }),
    
      
      search.addWidgets([
        instantsearch.widgets.refinementList({
          container: document.querySelector('#brand'),
          attribute: 'brand',
        })
      ]);
    
     */

    /* search.addWidgets([
        instantsearch.widgets.searchBox({
          container: '#searchbox',
        }),
    
        instantsearch.widgets.hits({
          container: '#hits',
          templates: {
            item: `
              <div>
                <img src="{{image}}" align="left" alt="{{name}}" />
                <div class="hit-name">
                  {{#helpers.highlight}}{ "attribute": "name" }{{/helpers.highlight}}
                </div>
                <div class="hit-description">
                  {{#helpers.highlight}}{ "attribute": "description" }{{/helpers.highlight}}
                </div>
                <div class="hit-price">\${{price}}</div>
              </div>
            `,
          },
        }),
        instantsearch.widgets.pagination({
          container: '#pagination',
        }),
      ]);
       */




})();