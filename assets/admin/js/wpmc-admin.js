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
                    title:" ",
                    options: {
                      disable_edit_json:false,
                      disable_properties: true,
                      disable_collapse:true
                    },
                    properties: {
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
                          collapsed: true,
                          disable_properties: true
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
                            },
                            "variableInput": {
                              title: "Is Input",
                              format: "checkbox",
                              type: "boolean"
                            },
                            "variablePct": {
                              title: "Is Percent",
                              format: "checkbox",
                              type: "boolean"
                            },
                            "variableValueFormula": {
                              title: "Formula",
                              format: "checkbox",
                              type: "boolean"
                            },
                            "variableValue": {
                              type: "string",
                              title: "Default Value"   
                            },
                            "values": {
                              title:"Advanced Mode Value",
                              $ref: "#/definitions/values"
                            }
                          }
                        }

                      }, //end variables

                      "values": {
                        type:"array",
                        title:"value title",
                        options:{
                          disable_collapse:true
                        },
                        items: {
                          type: "object",
                          title:"Value",
                          options:{
                            disable_collapse:true,
                            disable_edit_json:true,
                            disable_properties: true
                          },
                          properties: {
                            "arrayValue": {
                              type: "string",
                              title: "Value"   
                            },
                            "arrayValueLabel": {
                              type: "string",
                              title: "Label"
                            }
                          }
                        }
                      },

                      "groups": {
                        type: "array",
                        title: "Grouped Variables",

                        items: {
                          type: "object",
                          title:"Group",
                          options: {
                            disable_edit_json:true,
                            disable_properties: true,
                            collapsed: true
                          },
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
    codeMirrorIntegration : () => {
      return {
        init : () => {

          CodeMirror.defineMode("mustache", function(config, parserConfig) {
            var mustacheOverlay = {
              token: function(stream, state) {
                var ch;
                if (stream.match("{{")) {
                  while ((ch = stream.next()) != null)
                    if (ch == "}" && stream.next() == "}") {
                      stream.eat("}");
                      return "mustache";
                    }
                }
                while (stream.next() != null && !stream.match("{{", false)) {}
                return null;
              }
            };
            return CodeMirror.overlayMode(CodeMirror.getMode(config, parserConfig.backdrop || "text/html"), mustacheOverlay);
          });
          var ele = document.querySelectorAll('.crb-template textarea');//document.getElementsByClassName("crb-template");
          
          if(ele.length > 0){
            ele = ele[0];
          }
          //console.log(ele);
          if(ele && ele.length){
            var editor = CodeMirror.fromTextArea(ele, {mode: "mustache"});

            
            var tabs = document.querySelectorAll('.cf-container__tabs-item');
            for (var i = 0; i < tabs.length; i++) {
              tabs[i].addEventListener('click', function(event) {
                setTimeout(function() {
                  editor.refresh();
                },100);
              });
            }
          }



        },
        finalize: () => {}
      };
    }

  }


  $(document).ready( () => {
    
    var functionsToTrigger = [
      'bootJSEditor',
      'codeMirrorIntegration'
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