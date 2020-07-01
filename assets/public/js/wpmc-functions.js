(function(){

  WPMC.element = {};
  WPMC.getModels = getModels;
  WPMC.arrayObject = arrayObject;
  WPMC.initEventHandlers = initEventHandlers;
  WPMC.renderFormulas = renderFormulas;
  WPMC['$formulas'] = {};
  WPMC['$models'] = {};

  document.addEventListener("DOMContentLoaded", function(event) { 
    // var wpmc = WPMC.groups.map((group)=>{
    //   var ret = {};
    //   return {
    //     label: group.label,
    //     definition: group.definition,
    //     variables: group.variables
    //   };

    //   return ret;
    // });
    // arrayToObject( WPMC.groups );
    

    WPMC.arrayObject();
    WPMC.getModels();

    initHBHelpers();

    //init hbjs
    renderWPMC();

    //initial formual render
    // WPMC.renderFormulas();

    //init event handlers
    WPMC.initEventHandlers();

  });

  

  const arrayToObject = (array) =>
    array.reduce((obj, item) => {
     obj[item.name] = item;
     array[item.name]
     if(item.variables){
       item.variables = arrayToObject( item.variables );
       Object.assign(obj[item.name],item.variables);
     }
     return obj
   }, {});

  
  const computeModel = (expression, scope) => {
    var _scope = '';
    for (var prop in scope) {
      if (Object.prototype.hasOwnProperty.call(scope, prop)) {
        _scope = 'var '+prop+'='+JSON.stringify(scope[prop])+';';
      } 
    }
    localEval = ()=>{
      return Function('"use strict"; '+_scope+' return (' + expression + ')')();
    }     
  }

  // WPMC = arrayToObject( WPMC.groups );
  // console.log('NEW WPMC : ', newWPMC);

  function renderWPMC(){
    var source = document.getElementById("wpmc-groups").innerHTML;
    
    

    var template = Handlebars.compile(source);  

    var html = template(WPMC.groups);

    document.getElementById("wpmc-groups").nextElementSibling.innerHTML = html;

    WPMC.element = document.getElementById("wpmc-groups").nextElementSibling;

    tippy('[data-tippy-content]', {
      hideOnClick: true,
      duration: [100, 2000],
    });
    
  }

  function renderFormulas(){
    var models = this.$models;
    var formulas = this.$formulas;
    var scopeStr = '';

    for (var prop in models) {
      if (!Object.prototype.hasOwnProperty.call(this, prop)) {
          this[prop] = this.$models[prop];
      }
      scopeStr += 'var '+prop+'='+JSON.stringify(models[prop])+';';
    }
    console.log(scopeStr);

    for (var formulaProp in formulas) {

      if (Object.prototype.hasOwnProperty.call(formulas, formulaProp)) {
        var computed = parse(formulas[formulaProp].formula);
        formulas[formulaProp].ref.set( computed );
      }
    }

    function parse(str){

      return Function(`'use strict'; ${scopeStr} return (${str})`)();
    }


  }

  /* Custom Helpers */
  function initHBHelpers(hb){
    
    Handlebars.registerHelper('loud', function (aString,options) {
      return aString.toUpperCase()
    });

    Handlebars.registerHelper('stringify', function (obj,options) {
      return JSON.stringify(obj);
  });

  }

  /**
   * Event Handlers
   */
  function initEventHandlers(){
    var hasValues = this.element.querySelectorAll('.has-values');
    console.log(hasValues);
    //attach simple and advance mode
    
    hasValues.forEach((value, index,array)=>{
      if(value.dataset && value.dataset['values']){
        
        const dataValues = JSON.parse(value.dataset.values);
        if(dataValues.length > 0){
          
          const fieldInner = value.querySelector('.field-inner');
          if(fieldInner){
            const modeSelector = document.createElement('select');
            modeSelector.classList.add('mode-selector');
            modeSelector.innerHTML= '<option value="simple">Simple Mode</option> <option value="advance">Advance Mode</option>';
            fieldInner.insertBefore(modeSelector, fieldInner.firstChild);

            //add select change event handler
            modeSelector.onchange = (e) => {

              const valueDefault = e.target.parentElement.parentElement.dataset['default'];

              if(e.target.value === 'advance'){
                
                const valuesObj = JSON.parse( e.target.parentElement.parentElement.dataset['values'] ) ;

                const inputFieldsElement = document.createElement('div');
                inputFieldsElement.classList.add('adv-mode-fieldset');
                
                let inputFieldsHTML = '';
                valuesObj.forEach( (v,i,a)=>{
                  inputFieldsHTML = inputFieldsHTML + '<div class="adv-fieldset-inner"><label>'+v.arrayValueLabel+'</label><input type="text" name="" value="'+v.arrayValue+'" /></div>';      
                });

                inputFieldsElement.innerHTML = inputFieldsHTML;
                console.log('input field html >> ', e.target.nextElementSibling.innerHTML);
                e.target.nextElementSibling.remove();
                e.target.parentNode.insertBefore(inputFieldsElement, e.target.nextSibling);

              } else if(e.target.value === 'simple'){
                e.target.nextElementSibling.remove();
                const inputField = document.createElement('input');
                inputField.setAttribute('type','number');
                inputField.setAttribute('value',valueDefault);
                e.target.parentNode.insertBefore(inputField, e.target.nextSibling);
              }
            };

          }

        }

      }
      
    });

  }

  /*

  */

 function getModels (obj, storage) {
  !obj && (obj = WPMC.groups );
  !storage && (storage = WPMC.$models); 
  

  
  for (var prop in obj) {
    
    if(prop === '$models' || prop === '$formulas') continue;
    if( !isNaN(prop) ) continue;

    if (Object.prototype.hasOwnProperty.call(obj, prop)) {
      if(obj[prop].variables){
        !storage[prop] && (storage[prop]={});
        getModels(obj[prop].variables, storage[prop]);  
      } else if(obj[prop].variableValue && obj[prop].variableValue!=="N/A" ){
        if( obj[prop].variablePct){
          storage[prop] = parseFloat( obj[prop].variableValue ) / 100;   
        } else if(obj[prop].variableValueFormula){
          //!WPMC.$formulas[prop] && (WPMC.$formulas[prop] = {});
          //WPMC.$formulas[prop] = {'formula':obj[prop].variableValue, 'ref': storage};
          //ret[prop] = computeModel(obj[prop].variableValue, ret);
          //console.log('Compute Model >> ', ret[prop]);
          storage[prop]=null;
        } else {
          storage[prop] = parseFloat( obj[prop].variableValue );
        }

        if(obj[prop].variableValueFormula){
          var thisProp = prop+'';
          
          if(!WPMC.$formulas[prop]){
            WPMC.$formulas[prop] = {};
            console.log('empty render model',prop);
          } else {
            console.log('existing render model',prop);
          }
          //!WPMC.$formulas[prop] && (WPMC.$formulas[prop] = {});
          WPMC.$formulas[prop] = {'obj': obj[thisProp], 'formula':obj[prop].variableValue, 'ref': { get:()=>{ return storage[thisProp] }, set:(nVal)=>{ console.log(thisProp); storage[thisProp]=nVal }} };
          console.log('>>>', WPMC.$formulas[prop]);
        }


      }
    }

  }  

};


function arrayObject (array) {
  !array && (array=WPMC.groups);

  for (var prop in array) {
    if(array[prop].name){

      if(array[prop].variables){
        arrayObject( array[prop].variables );  
      }
      array[ array[prop].name ] = array[prop];
    }
  } 

}


})();