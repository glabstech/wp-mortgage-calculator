(function($){

  /**
   * 
   */
  
  var wpmcFunctions = {
    
    bootJSEditor: ()=>{
      if( ! $('.wpmc_variable_object') ) return false;

      return {
        init: ()=>{
            // Initialize the json-editor

            JSONEditor.defaults.custom_validators.push((schema, value, path) => {
              const errors = [];

              if( (path === "root.variables" || path === "root.groups") && (value && value.length)){
                console.log("value: ",value, "path: ", path);  
              }

              // console.log('custom checking >> ',value, schema, path);

              // if (schema.format==="date") {
              //   if (!/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/.test(value)) {
              //     // Errors must be an object with `path`, `property`, and `message`
              //     errors.push({
              //       path: path,
              //       property: 'format',
              //       message: 'Dates must be in the format "YYYY-MM-DD"'
              //     });
              //   }
              // }
              return errors;
            });



            
            $('.wpmc_variable_object').each((index, element)=>{
                var editor = new JSONEditor(element,{
  
                  iconlib: 'fontawesome4',
                  "compact":true,
                  "disable_array_delete_all_rows":true,
                  "startval": JSON.parse( $(element).find('textarea.cf-textarea__input').val() ),
                  // The schema for the editor
                  schema: {
                    title:"Configuration",
                    properties: {
                      "variables": {
                        $ref: "#/definitions/variables"
                      },
                      "groups": {
                        $ref: "#/definitions/groups"
                      }
                    },
                    definitions: {
                      "variables" : {
                        title: "Variables",
                        type: "array",
                        format: "table",
                        options: {
                          collapsed: true
                        },
                        items: {
                          type: "object",
                          title:"Variable",
                          properties: {
                            "label": {
                              type: "string",
                              title: "Label"
                            },
                            "name": {
                              type: "string",
                              title: "Name"
                            },
                            "definition": {
                              title: "Definition",
                              type: "string",
                              format: "textarea"
                            }
                          }
                        }

                      }, //end variables

                      "groups": {
                        type: "array",
                        title: "Grouped Variables",
                        options: {
                          collapsed: true
                        },
                        items: {
                          type: "object",
                          title:"Group",
                          properties: {
                            "label": {
                              type: "string",
                              title: "Group Title"
                            },
                            "name": {
                              type: "string",
                              title: "Name"
                            },
                            "definition": {
                              tutle: "Definition",
                              type: "string",
                              format: "textarea"
                            },
                            "variables": {
                              title:"Variables",
                              $ref: "#/definitions/variables"
                            }
                            
                          }
                        }
                      }
                    }
                  }
              });

              //monitor
              editor.watch('root',() => {
                var groups = editor.getEditor('root')
                $('.wpmc_variable_object textarea.cf-textarea__input').val( JSON.stringify( groups.getValue() ) );
              });

            });
          
        },
        finalize: () => {
          console.log('bootJSEditor finalize');
        }
      };
    },
    adminCarbonFieldAPI : () => {
      return {
        init : () => {
          // $(document).on('carbonFields.apiLoaded', function(e, api) {

          // });  
        },
        finalize: () => {}
      };
    }

  }


  $(document).ready( () => {
    
    var functionsToTrigger = [
      'bootJSEditor',
      'adminCarbonFieldAPI'
    ];

    //Fire Init Functions
    functionsToTrigger.forEach( (item, index )=>{
      if( wpmcFunctions[item] && wpmcFunctions[item]().init ){
        wpmcFunctions[item]().init();
      }
    });

    //Fire Finalize Functions
    functionsToTrigger.forEach( (item, index )=>{
      if( wpmcFunctions[item] && wpmcFunctions[item]().finalize ){
        wpmcFunctions[item]().finalize();
      }
    });

  });

})(jQuery);