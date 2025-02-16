/*
 =====================================================================
 Redistribution and use in source and binary forms, with or without
 modification, are permitted provided that the following conditions
 are met:

 1. Redistributions of source code must retain the above
 copyright notice, this list of conditions and the following
 disclaimer.

 2. Redistributions in binary form must reproduce the above
 copyright notice, this list of conditions and the following
 disclaimer in the documentation and/or other materials provided
 with the distribution.

 3. The name of the author may not be used to endorse or promote
 products derived from this software without specific prior
 written permission.

 THIS SOFTWARE IS PROVIDED BY THE AUTHOR ``AS IS'' AND ANY EXPRESS
 OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 ARE DISCLAIMED. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY
 DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
 WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

 @author Daniel Kwiecinski <daniel.kwiecinski@lambder.com>
 @copyright 2009 Daniel Kwiecinski.
 @end
 =====================================================================
*/


//-------------------- vanadium-jquery.js -----------------------------


Vanadium = {};
Vanadium.Version = '0.1';
Vanadium.CompatibleWithJQuery = '1.3.2';
Vanadium.Type = "jquery";

if (jQuery().jquery.indexOf(Vanadium.CompatibleWithJQuery) != 0 && window.console && window.console.warn)
  console.warn("This version of Vanadium is tested with jQuery " + Vanadium.CompatibleWithJQuery +
               " it may not work as expected with this version (" + jQuery().jquery + ")");

Vanadium.each = jQuery.each;

Vanadium.all_elements = function() {
  return jQuery('*');
};

Vanadium.partition = function(elements, dyscriminator) {
  var left = [];
  var right = [];
  Vanadium.each(elements, function() {
    if (dyscriminator(this)) {
      left.push(this);
    } else {
      right.push(this);
    }
    ;
  });
  return [left, right];
};




//-------------------- vanadium-hashmap.js -----------------------------


var HashMap = function() {
  this.initialize();
}

HashMap.hashmap_instance_id = 0;

HashMap.prototype = {
  hashkey_prefix: "<#HashMapHashkeyPerfix>",
  hashcode_field: "<#HashMapHashcodeField>",

  initialize: function() {
    this.backing_hash = {};
    this.code = 0;
    HashMap.hashmap_instance_id += 1;
    this.instance_id = HashMap.hashmap_instance_id;
  },

  hashcodeField: function() {
    return this.hashcode_field + this.instance_id;
  },
  /*
   maps value to key returning previous assocciation
   */
  put: function(key, value) {
    var prev;

    if (key && value) {
      var hashCode;
      if (typeof(key) === "number" || typeof(key) === "string") {
        hashCode = key;
      } else {
        hashCode = key[this.hashcodeField()];
      }
      if (hashCode) {
        prev = this.backing_hash[hashCode];
      } else {
        this.code += 1;
        hashCode = this.hashkey_prefix + this.code;
        key[this.hashcodeField()] = hashCode;
      }
      this.backing_hash[hashCode] = [key, value];
    }
    return prev === undefined ? undefined : prev[1];
  },
  /*
   returns value associated with given key
   */
  get: function(key) {
    var value;
    if (key) {
      var hashCode;
      if (typeof(key) === "number" || typeof(key) === "string") {
        hashCode = key;
      } else {
        hashCode = key[this.hashcodeField()];
      }
      if (hashCode) {
        value = this.backing_hash[hashCode];
      }
    }
    return value === undefined ? undefined : value[1];
  },
  /*
   deletes association by given key.
   Returns true if the assocciation existed, false otherwise
   */
  del: function(key) {
    var success = false;
    if (key) {
      var hashCode;
      if (typeof(key) === "number" || typeof(key) === "string") {
        hashCode = key;
      } else {
        hashCode = key[this.hashcodeField()];
      }
      if (hashCode) {
        var prev = this.backing_hash[hashCode];
        this.backing_hash[hashCode] = undefined;
        if (prev !== undefined){
          key[this.hashcodeField()] = undefined; //let's clean the key object
          success = true;
        }
      }
    }
    return success;
  },
  /*
   iterate over key-value pairs passing them to provided callback
   the iteration process is interrupted when the callback returns false.
   the execution context of the callback is the value of the key-value pair
   @ returns the HashMap (so we can chain)                                                                  (
   */
  each: function(callback, args) {
    var key;
    for (key in this.backing_hash){
      if (callback.call(this.backing_hash[key][1], this.backing_hash[key][0], this.backing_hash[key][1]) === false)
        break;
    }
    return this;
  },
  toString: function() {
    return "HashMapJS"
  }

}


//-------------------- vanadium-container.js -----------------------------


Vanadium.containers = new HashMap();

var ContainerValidation = function(html_element) {
  this.initialize(html_element)
}

ContainerValidation.prototype = {
  initialize: function(html_element) {
    this.html_element = html_element;
    this.elements = [];
  },
  add_element: function(element) {
    this.elements.push(element);
  },
  decorate: function() {
    var valid = null;
    for (var id in this.elements) {
      if (this.elements[id].invalid === undefined) {
        valid = undefined;
      } else if (this.elements[id].invalid === true) {
        valid = false;
        break;
      } else if (this.elements[id].invalid === false && valid === null) {
        valid = true;
      }
    }
    if (valid === undefined) {
      jQuery(this.html_element).removeClass(Vanadium.config.invalid_class);
      jQuery(this.html_element).removeClass(Vanadium.config.valid_class);
    } else if (valid) {
      jQuery(this.html_element).removeClass(Vanadium.config.invalid_class);
      jQuery(this.html_element).addClass(Vanadium.config.valid_class);
    } else {
      jQuery(this.html_element).removeClass(Vanadium.config.valid_class);
      jQuery(this.html_element).addClass(Vanadium.config.invalid_class);
    }
  }
}

//-------------------- vanadium-form.js -----------------------------


var VanadiumForm = function(element) {
    this.initialize(element);
}

Vanadium.forms = new HashMap();

VanadiumForm.add_element = function(validation_element) {
    var form = validation_element.element.form;
    if (form) {
        var vanadum_form = Vanadium.forms.get(form);
        if (vanadum_form) {
            vanadum_form.validation_elements.push(validation_element);
        } else {
            vanadum_form = new VanadiumForm(validation_element);
            Vanadium.forms.put(form, vanadum_form);
        }
    }
}


VanadiumForm.prototype = {

    initialize: function(validation_element) {
        this.validation_elements = [validation_element];
        this.form = validation_element.element.form;
        var self = this;
        var on_form_submit = function() {
            var validation_result = self.validate();

            var success = true;
            validation_result.each(function(_element, validation_results) {
                for (var r in validation_results) {
                    if (validation_results[r].success == false) {
                        success = false;
                        break;
                    }
                }
                if (success == false) {
                    return false;// break from hashmap iteration
                }
            });
            if (!success) {
                self.decorate();
                return false;
            }
            return success;
        };

        //jQuery(this.form).submit(on_form_submit);
        jQuery(this.form).find(':submit').click(function() {
            return on_form_submit();
        });

        this.form.decorate = function() {
            self.decorate();
        }
    },

    validate: function() {
        var validation = new HashMap();
        Vanadium.each(this.validation_elements,
                function() {
                    validation.put(this, this.validate());
                });
        return validation;
    },

    decorate: function(validation_results) {
        if (arguments.length == 0) {
            validation_results = this.validate();
        }
        validation_results.each(function(element, element_validation_results) {
            element.decorate(element_validation_results);
        });
    },

    validateAndDecorate: function() {
        this.decorate(this.validate())
    }
}


//-------------------- vanadium-base.js -----------------------------




Vanadium.validators_types = {};
Vanadium.elements_validators_by_id = {};
Vanadium.all_elements_validators = [];
Vanadium.created_advices = [];

Vanadium.all_html_elements = new HashMap();


//default config
Vanadium.config = {
    valid_class: 'vanadium-valid',
    invalid_class: 'vanadium-invalid',
    message_value_class: 'vanadium-message-value',
    advice_class: 'vanadium-advice',
    prefix: ':',
    separator: ';',
    reset_defer_timeout: 100
}

Vanadium.empty_advice_marker_class = '-vanadium-empty-advice-'

//validation rules
Vanadium.rules = {}


Vanadium.init = function() {
    this.setupValidatorTypes();
    this.scan_dom();
}


Vanadium.addValidatorType = function(className, validationFunction, error_message, message, init) {
    this.validators_types[className] = new Vanadium.Type(className, validationFunction, error_message, message, init);
};

Vanadium.addValidatorTypes = function(validators_args) {
    var self = this;
    Vanadium.each(validators_args,
            function() {
                Vanadium.addValidatorType.apply(self, this);
            }
            )
};


Vanadium.scan_dom = function() {
    Vanadium.each(Vanadium.all_elements(),
            function(_idx, child) {

                var class_names = child.className.split(' ');
                if (Vanadium.is_input_element(child)) {
                    var element_validation = new ElementValidation(child);

                    if (child.id)
                        Vanadium.elements_validators_by_id[child.id] = element_validation

                    Vanadium.all_elements_validators.push(element_validation)
                    Vanadium.all_html_elements.put(child, element_validation);

                    VanadiumForm.add_element(element_validation);

                    //create validation rules based on class markup
                    Vanadium.each(class_names,
                            function() {
                                var parameters = Vanadium.parse_class_name(this);
                                /*'this' is class_name*/
                                if (parameters) {
                                    Vanadium.add_validation_instance(element_validation, parameters);
                                    Vanadium.add_validation_modifier(element_validation, parameters);
                                }
                            });
                    //create validation rules based on json providen in VanadiumRules variable
                    Vanadium.each(Vanadium.get_rules(child.id),
                            function() {
                                var parameters = this;
                                if (parameters) {
                                    Vanadium.add_validation_instance(element_validation, parameters);
                                    Vanadium.add_validation_modifier(element_validation, parameters);
                                }
                            });
                    element_validation.setup();
                } else {
                    Vanadium.add_validation_container(child);
                }
            })
}

Vanadium.add_validation_container = function(element) {
    var class_names = element.className.split(' ');
    Vanadium.each(class_names,
            function() {
                var parameters = Vanadium.parse_class_name(this);
                if (parameters[0] == 'container') {
                    Vanadium.containers.put(element, new ContainerValidation(element));
                    return true
                }
            });
    Vanadium.each(Vanadium.get_rules(element.id),
            function() {
                var rule = this;
                if (rule == 'container') {
                    Vanadium.containers.put(element, new ContainerValidation(element));
                    return true
                }
            });
}

Vanadium.get_rules = function(element_id) {
    var rule_from_string_or_hash = function(r) {
        if (typeof r === "string") {
            return [r];
        } else if (Vanadium.isArray(r)) {
            return r;
        } else if (typeof(r) === "object") {
            return [r.validator, r.parameter, r.advice];
        } else {
            return undefined;
        }
    }
    //
    var rules = [];
    //
    var rs = Vanadium.rules[element_id];
    if (typeof rs === "undefined") {
        return [];
    } else if (typeof rs === "string") {
        rules.push(rs);
    } else if (Vanadium.isArray(rs)) {
        for (var r in rs) {
            rules.push(rule_from_string_or_hash(rs[r]));
        }
    } else if (typeof(rs) === "object") {
        rules.push(rule_from_string_or_hash(rs));
    }
    return rules;
}

Vanadium.parse_class_name = function(class_name) {
    if (class_name.indexOf(Vanadium.config.prefix) == 0) {
        var v_params = class_name.substr(Vanadium.config.prefix.length).split(Vanadium.config.separator)
        for (var key in v_params) {
            if (v_params[key] == "") {
                v_params[key] = undefined
            }
        }
        return v_params;
    } else {
        return [];
    }
}

Vanadium.add_validation_instance = function(element_validation, parameters) {
    var v_name = parameters[0];
    var v_param = parameters[1];
    var v_advice_id = parameters[2];
    var validator_type = Vanadium.validators_types[v_name]
    if (validator_type) {
        element_validation.add_validation_instance(validator_type, v_param, v_advice_id);
    }
}

Vanadium.add_validation_modifier = function(element_validation, parameters) {
    var m_name = parameters[0];
    var m_param = parameters[1];
    if (m_name == 'only_on_blur' || m_name == 'only_on_submit' || m_name == 'wait' || m_name == 'advice') {
        element_validation.add_validation_modifier(m_name, m_param);
    }
}

Vanadium.validate = function() {
    var validation = new HashMap();
    Vanadium.each(Vanadium.all_elements_validators,
            function() {
                validation.put(this, this.validate());
            });
    return validation;
}

Vanadium.validateAndDecorate = function(html_element) {
    if (typeof html_element === "undefined") {  // validate and decorate everything
        Vanadium.decorate(Vanadium.validate());
    } else if (html_element.nodeType == 1) {
        var element_validation = Vanadium.all_html_elements.get(html_element) || Vanadium.forms.get(html_element);
        if (element_validation) {
            element_validation.validateAndDecorate(false);
        }
    }
}

Vanadium.decorate = function(validation_results) {
    if (typeof validation_results === "object") {
        if (validation_results.toString() == "HashMapJS") {
            validation_results.each(function(element, element_validation_results) {
                element.decorate(element_validation_results);
            })
        } else {//this is probably json structure representing validation result
            var element_id;
            for (element_id in validation_results) {
                var element = Vanadium.elements_validators_by_id[element_id];
                if (element) {
                    element.decorate(validation_results[element_id]);
                }
            }
        }
    }
}

Vanadium.reset = function() {
    Vanadium.each(Vanadium.all_elements_validators,
            function() {
                this.reset();
            });
}






//-------------------- vanadium-utils.js -----------------------------





Vanadium.isArray = function(object) {
  return object != null && typeof object == "object" &&
         'splice' in object && 'join' in object;

}

Vanadium.isFunction = function(object) {
  return object != null && object.toString() === "[object Function]";
}

Vanadium.extend = function(extension) {
  var args = [Vanadium];
  for (var idx = 0; idx < arguments.length; idx++) {
    args.push(arguments[idx]);
  }
  return jQuery.extend.apply(jQuery, args);
}

Vanadium.bind = function(fun, context) {
  return function() {
    return fun.apply(context, arguments);
  }
}

//-------------------- vanadium-dom.js -----------------------------


Vanadium.extend(
{

  /**
   *	gets the type of element, to check whether it is compatible
   */
  getElementType: function(element) {
    switch (true) {
      case (element.nodeName.toUpperCase() == 'TEXTAREA'):
        return Vanadium.TEXTAREA;
      case (element.nodeName.toUpperCase() == 'INPUT' && element.type.toUpperCase() == 'TEXT'):
        return Vanadium.TEXT;
      case (element.nodeName.toUpperCase() == 'INPUT' && element.type.toUpperCase() == 'PASSWORD'):
        return Vanadium.PASSWORD;
      case (element.nodeName.toUpperCase() == 'INPUT' && element.type.toUpperCase() == 'CHECKBOX'):
        return Vanadium.CHECKBOX;
      case (element.nodeName.toUpperCase() == 'INPUT' && element.type.toUpperCase() == 'FILE'):
        return Vanadium.FILE;
      case (element.nodeName.toUpperCase() == 'SELECT'):
        return Vanadium.SELECT;
      case (element.nodeName.toUpperCase() == 'INPUT'):
        throw new Error('Vanadium::getElementType - Cannot use Vanadium on an ' + element.type + ' input!');
      default:
        throw new Error('Vanadium::getElementType - Element must be an input, select, or textarea!');
    }
    ;
  },
  is_input_element : function(element) {
    return (element.nodeName.toUpperCase() == 'TEXTAREA') ||
           (element.nodeName.toUpperCase() == 'INPUT' && element.type.toUpperCase() == 'TEXT') ||
           (element.nodeName.toUpperCase() == 'INPUT' && element.type.toUpperCase() == 'PASSWORD') ||
           (element.nodeName.toUpperCase() == 'INPUT' && element.type.toUpperCase() == 'CHECKBOX') ||
           (element.nodeName.toUpperCase() == 'INPUT' && element.type.toUpperCase() == 'FILE') ||
           (element.nodeName.toUpperCase() == 'SELECT')
  },
  /**
   *	makes a span containg the passed or failed advice
   *
   * @return {HTMLSpanObject} - a span element with the advice message in it
   */
  createAdvice: function(element, advice_id, message) {
    var advice = document.createElement('span');
    advice.id = advice_id;
    var textNode = document.createTextNode(message);
    advice.appendChild(textNode);
    element.parentNode.insertBefore(advice, element.nextSibling);
    this.created_advices.push(advice);
  },

  /**
   *	adds the class of the element/advice/container to indicte if valid or not
   */
  addValidationClass: function(element, valid) {
    if (element) {
      this.removeValidationClass(element);
      if (valid) {
        element.className += ' ' + Vanadium.config.valid_class;
      } else {
        element.className += ' ' + Vanadium.config.invalid_class;
      }
      ;
    }
    ;
  },
  /**
   *	removes the class that has been applied to the element/advice/container to indicte if valid or not
   */
  removeValidationClass: function(element) {
    if (element) {
      if (element.className.indexOf(Vanadium.config.invalid_class) != -1) element.className = element.className.split(Vanadium.config.invalid_class).join(' ');
      if (element.className.indexOf(Vanadium.config.valid_class) != -1) element.className = element.className.split(Vanadium.config.valid_class).join(' ');
    }
    ;
  },
  /** element types constants ****/
  TEXTAREA: 1,
  TEXT: 2,
  PASSWORD: 3,
  CHECKBOX: 4,
  SELECT: 5,
  FILE: 6
}
        );


//-------------------- vanadium-element.js -----------------------------


ElementValidation = function(element) {
  this.initialize(element)
};
ElementValidation.prototype = {

  initialize: function(element) {
    this.virgin = true;
    this.element = element;
    this.validations = [];
    this.only_on_blur = false;
    this.only_on_submit = false;
    this.wait = 100;
    this.created_advices = [];
    this.decorated = false;
    this.containers = null;
    this.invalid = undefined;
    this.advice_id = undefined; //this is general common advice for all validation instances having no specific advice defined
  },

  add_validation_instance: function(validator_type, param, advice_id) {
    this.validations.push(new Validation(this.element, validator_type, param, advice_id));
  },
  add_validation_modifier: function(modifier, param) {
    if (modifier == 'only_on_blur') {
      //  whether you want it to validate as you type or only on blur  (DEFAULT: false)
      this.only_on_blur = true
    } else if (modifier == 'only_on_submit') {
      //  whether should be validated only when the form it belongs to is submitted (DEFAULT: false)
      this.only_on_submit = true
    } else if (modifier == 'wait') {
      //  the time you want it to pause from the last keystroke before it validates (ms) (DEFAULT: 0)
      var milisesonds = parseInt(param);
      if (milisesonds != NaN && typeof(milisesonds) === "number") {
        this.wait = milisesonds;
      }
      ;
    } else if (modifier == 'advice') {
      var advice = document.getElementById(param);
      if (advice) {
        this.advice_id = param;
      }
    }
    ;
  },
  element_containers: function() {
    if (this.containers === null) {
      this.containers = new HashMap();
      var parent = this.element.parentNode;
      //search up the DOM tree
      while (parent != document) {
        var container = Vanadium.containers.get(parent);
        if (container) {
          container.add_element(this);
          this.containers.put(parent, container);
        }
        ;
        parent = parent.parentNode;
      }
      ;
    }
    ;
    return this.containers;
  },
  // context - the contect in which decoration_callback should be invoked
  // decoration_callback - the decoration used by asynchronous validation
  validate: function(decoration_context, decoration_callback) {
    var result = [];
    Vanadium.each(this.validations, function() {
      result.push(this.validate(decoration_context, decoration_callback));
    });
    return result;
  },
  decorate: function(element_validation_results, do_not_reset) {
    if (!do_not_reset) {
      this.reset();
    }
    this.decorated = true;
    var self = this;
    var passed_and_failed = Vanadium.partition(element_validation_results, function(validation_result) {
      return validation_result.success
    });
    var passed = passed_and_failed[0];
    var failed = passed_and_failed[1];
    // add apropirate CSS class to the validated element
    if (failed.length > 0) {
      this.invalid = true; //mark this validation element as invalid
      Vanadium.addValidationClass(this.element, false);
    } else if (passed.length > 0 && !this.invalid) { //when valid result comes but the previous was invalid and no reset was done, the invalid flag should stay unchanged
      this.invalid = false; //mark this validation element as valid
      Vanadium.addValidationClass(this.element, true);
    } else {
      this.invalid = undefined; //mark this validation element as undefined
    }
    ;
    // add apropirate CSS class to the validated element's containers
    this.element_containers().each(function(_element, container) {
      container.decorate();
    });
    //
    Vanadium.each(failed, function(_idx, validation_result) {
      var advice = undefined;
      if (self.advice_id) {
        advice = document.getElementById(self.advice_id);
      }
      if (advice || validation_result.advice_id) {
        advice = advice || document.getElementById(validation_result.advice_id);
        if (advice) {
          jQuery(advice).addClass(Vanadium.config.advice_class);
          var advice_is_empty = advice.childNodes.length == 0
          if (advice_is_empty || jQuery(advice).hasClass(Vanadium.empty_advice_marker_class)) {
            jQuery(advice).addClass(Vanadium.empty_advice_marker_class);
            jQuery(advice).append("<span>" + validation_result.message + "</span>");
          }
          ;
          jQuery(advice).show();
        } else {
          advice = self.create_advice(validation_result);
        }
        ;
      } else {
        advice = self.create_advice(validation_result);
      }
      ;
      Vanadium.addValidationClass(advice, false);
    });
  },
  validateAndDecorate : function(regard_virginity) {
    //That's tricky one ;)
    // 1. we are runing validate to get all validation results
    // 2. there could be possible some validations running asynchronous
    // so we won't get the result imediately. In that case the provided decoration callback
    // will be invoked on return from asynchronous callback
    // It is used by Ajax based server-side validation
    if(!regard_virginity || !this.virgin)
      this.decorate(this.validate(this, this.decorate));
  },
  create_advice: function(validation_result) {
    var span = document.createElement("span");
    this.created_advices.push(span);
    jQuery(span).addClass(Vanadium.config.advice_class);
    jQuery(span).html(validation_result.message);
    jQuery(this.element).after(span);
    return span;
  },
  reset: function() {
    this.invalid = undefined; //mark this validation element as undefined
    //    this.element_containers().each(function(_element, container) {
    //      container.decorate();
    //    });
    var element_advice = document.getElementById(this.advice_id);
    if (element_advice) {
      if (jQuery(element_advice).hasClass(Vanadium.empty_advice_marker_class)) {
        jQuery(element_advice).empty();
      }
      jQuery(element_advice).hide();
    }
    Vanadium.each(this.validations, function() {
      var advice = document.getElementById(this.adviceId);
      if (advice) {
        if (jQuery(advice).hasClass(Vanadium.empty_advice_marker_class)) {
          jQuery(advice).empty();
        }
        jQuery(advice).hide();
      }
      ;
    });

    var created_advice = this.created_advices.pop();
    while (!(created_advice === undefined)) {
      jQuery(created_advice).remove();
      created_advice = this.created_advices.pop();
    }
    ;
    Vanadium.removeValidationClass(this.element);
  },
  //
  //
  //
  /**
   * makes the validation wait the alotted time from the last keystroke
   */
  deferValidation: function() {
    if (this.wait >= 300) this.reset();
    var self = this;
    if (self.timeout) clearTimeout(self.timeout);
    self.timeout = setTimeout(function() {
      jQuery(self.element).trigger('validate');
    }, self.wait);
  },
  deferReset: function() {
    var self = this;
    if (self.reset_timeout) clearTimeout(self.reset_timeout);
    self.reset_timeout = setTimeout(function() {
      self.reset();
    }, Vanadium.config.reset_defer_timeout);
  },
  setup: function() {
    var self = this;
    this.elementType = Vanadium.getElementType(this.element);

    this.form = this.element.form;

    this.element_containers();

    if (!this.only_on_submit) {
      this.observe();
      jQuery(self.element).bind('validate', function() {
        self.validateAndDecorate.call(self, true)
      });
      jQuery(self.element).bind('defer_validation', function() {
        self.deferValidation.call(self)
      });
      jQuery(self.element).bind('reset', function() {
        self.reset.call(self)
      });
    }

  },
  observe: function() {
    var element = this.element;
    var elementType = Vanadium.getElementType(element);
    var self = this;
    jQuery(element).focus(function() {
      self.virgin = false;
    });
    switch (elementType) {
      case Vanadium.CHECKBOX:
        jQuery(element).click(function() {
          //TODO check db click !!!
          self.virgin = false; //this is here 'cos safari do not focus on checkboxes
          jQuery(self.element).trigger('validate');
        });
        break;
      //TODO check if checkboxes support on-change too. and if yes handle it!
      // let it run into the next to add a change event too
      case Vanadium.SELECT:
      case Vanadium.FILE:
        jQuery(element).change(function() {
          jQuery(element).trigger('validate');
        });
        break;
      default:
        jQuery(element).keydown(function(e) {
          if (e.keyCode != 9) {//no tabulation as it changes focus
            jQuery(element).trigger('reset');
          }
          ;
        });

        if (!this.only_on_blur) {
          jQuery(element).keyup(function(e) {
            if (e.keyCode != 9) {//no tabulation as it changes focus
              jQuery(element).trigger('defer_validation');
            }
            ;
          });
        };
        jQuery(element).blur(function() {
          jQuery(element).trigger('validate');
        });
    }
  }
};

//-------------------- vanadium-instance.js -----------------------------


var Validation = function(element, validation_type, param, advice_id) {
  this.initialize(element, validation_type, param, advice_id)
}

Validation.prototype = {
  initialize: function(element, validation_type, param, advice_id) {
    this.element = element;
    this.validation_type = validation_type;
    this.param = param;
    //
    this.adviceId = advice_id;
    var advice = document.getElementById(advice_id);
    if (advice) {
      jQuery(advice).addClass(Vanadium.config.advice_class);
    }
    if(this.validation_type.init){//Vanadium.isFunction(this.validation_type.init)){
      this.validation_type.init(this); //this give us oportunity to define in validation_type scope activity which will be performed on its instance initialisation
    }
  },
  emmit_message: function(message) {
    if (typeof(message) === "string") {
      return message;
    } else if (typeof(message) === "function") {
      return message.call(this, jQuery(this.element).val(), this.param);
    }
  },
  validMessage: function() {
    return this.emmit_message(this.validation_type.validMessage()) || 'ok'
  },
  invalidMessage: function() {
    return this.emmit_message(this.validation_type.invalidMessage()) || 'error'
  },
  test: function(decoration_context, decoration_callback) {
    return this.validation_type.validationFunction.call(this, jQuery(this.element).val(), this.param, this, decoration_context, decoration_callback);
  },
  // decoration_context - the contect in which decoration_callback should be invoked
  // decoration_callback - the decoration used by asynchronous validation
  validate: function(decoration_context, decoration_callback) {
    var return_value = {
      success: false,
      message: "Received invalid return value."
    }
    var validation_result = this.test(decoration_context, decoration_callback);
    if (typeof validation_result === "boolean") {
      return {
        success: validation_result,
        advice_id: this.adviceId,
        message: (validation_result ? this.validMessage() : this.invalidMessage())
      }
    } else if (typeof validation_result === "object") {
      jQuery.extend.apply(return_value, validation_result);
    }
    return return_value;
  }
}

//-------------------- vanadium-types.js -----------------------------


Vanadium.Type = function(className, validationFunction, error_message, message, init) {
  this.initialize(className, validationFunction, error_message, message, init);
};
Vanadium.Type.prototype = {
  initialize: function(className, validationFunction, error_message, message, init) {
    this.className = className;
    this.message = message;
    this.error_message = error_message;
    this.validationFunction = validationFunction;
    this.init = init;
  },
  test: function(value) {
    return this.validationFunction.call(this, value);
  },
  validMessage: function() {
    return this.message;
  },
  invalidMessage: function() {
    return this.error_message;
  },
  toString: function() {
    return "className:" + this.className + " message:" + this.message + " error_message:" + this.error_message
  },
  init: function(parameter) {
    if (this.init) {
      this.init(parameter);
    }
  }
};

Vanadium.setupValidatorTypes = function() {

  Vanadium.addValidatorType('empty', function(v) {
    return  ((v == null) || (v.length == 0));
  });

  Vanadium.addValidatorTypes([
    ['equal', function(v, p) {
      return v == p;
    }, function (_v, p) {
      return 'The value should be equal to <span class="' + Vanadium.config.message_value_class + '">' + p + '</span>.'
    }],
    //
    ['equal_ignore_case', function(v, p) {
      return v.toLowerCase() == p.toLowerCase();
    }, function (_v, p) {
      return 'The value should be equal to <span class="' + Vanadium.config.message_value_class + '">' + p + '</span>.'
    }],
    //
    ['required', function(v) {
      return !Vanadium.validators_types['empty'].test(v);
    }, 'Este campo es requerido.'],
    //
    ['accept', function(v, _p, e) {
      return e.element.checked;
    }, 'Must be accepted!'],
    //
    ['integer', function(v) {
      if (Vanadium.validators_types['empty'].test(v)) return true;
      var f = parseFloat(v);
      return (!isNaN(f) && f.toString() == v && Math.round(f) == f);
    }, 'Please enter a valid integer in this field.'],
    //
    ['number', function(v) {
      return Vanadium.validators_types['empty'].test(v) || (!isNaN(v) && !/^\s+$/.test(v));
    }, 'Por favor use solo numeros en este campo.'],
    //
    ['TelefonosAmbos', function (v) {
    return Vanadium.validators_types['empty'].test(v) || /^(2|6|7)[\d]{7}/.test(v)   //Valida el primer digito de Celular 6 y 7
    }, 'Este campo es para Celulares o Fijos y son 8 digitos'], 
    //
    ['TelefonoMovil', function (v) {
    return Vanadium.validators_types['empty'].test(v) || /^(6|7)[\d]{7}/.test(v)   //Valida el primer digito de Celular 6 y 7
    }, 'Este campo es para Celulares y son 8 digitos'], 
    //
    ['TelefonoFijo', function (v) {
    return Vanadium.validators_types['empty'].test(v) || /^(2)[\d]{7}/.test(v)   //Valida el primer digito de Telefonos fijos 2
    }, 'Este campo es para Telefonos Fijos y son 8 digitos'], 
    //
    ['dir2', function (v) {
    return Vanadium.validators_types['empty'].test(v) || /^[A-Z]/.test(v)   //Valida el primer digito de Telefonos fijos 2
    }, 'Este campo es para mayusculas'], 
    //
    ['Solicitud', function (v) {
    return Vanadium.validators_types['empty'].test(v) || /^32{1}\S\d+/.test(v)   //Valida el primer digito de Telefonos fijos 2
    }, 'Este no es numero de Correlativo de Gestion. Por ejemplo 32/9999'], 
   
    ['Prestamo', function (v) {
    return Vanadium.validators_types['empty'].test(v) || /^[0032|32][\d]{11,12}$/.test(v)   //Valida los numeros de prestamos
    }, 'No corresponde a un numero de prestamo'], 

    ['MatriculaCNR', function (v) {
    return Vanadium.validators_types['empty'].test(v) || /^\d[^12346789]\d{6}-[A-Z0-9]{5}$/.test(v)   //Valida los numeros de prestamos
    }, 'No corresponde a un numero de matricula del CNR'], 

    ['Presentacion', function (v) {
    return Vanadium.validators_types['empty'].test(v) || /^\d{4}(01|02|03|04|05|06|07|08|09|10|11|12|13|14)\d{6}$/.test(v)   //Valida los numeros de prestamos
    }, 'No corresponde a un numero de presentacion del CNR'], 
    //   
    ['float', function(v) {
      return Vanadium.validators_types['empty'].test(v) || (!isNaN(v) && !/^\s+$/.test(v));
    }, 'Please enter a valid number in this field.'],
    //
    ['digits', function(v) {
      return Vanadium.validators_types['empty'].test(v) || !/[^\d]/.test(v);
    }, 'Please use numbers only in this field. please avoid spaces or other characters such as dots or commas.'],
    //
    ['alpha', function (v) {
      return Vanadium.validators_types['empty'].test(v) || /^[a-zA-Z \u00C0-\u00FF\u0100-\u017E\u0391-\u03D6]+$/.test(v)   //% C0 - FF (� - �); 100 - 17E (? - ?); 391 - 3D6 (? - ?)
    }, 'Por favor use solo letras en este campo.'],
    //
    //
    ['fecha', function (v) {
      return Vanadium.validators_types['empty'].test(v) || /^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/.test(v)   //% C0 - FF (� - �); 100 - 17E (? - ?); 391 - 3D6 (? - ?)
    }, 'Por favor utilizar el siguiente formato para fecha aaaa-mm-dd.'],
    //
    ['asciialpha', function (v) {
      return Vanadium.validators_types['empty'].test(v) || /^[a-zA-Z]+$/.test(v)   //% C0 - FF (� - �); 100 - 17E (? - ?); 391 - 3D6 (? - ?)
    }, 'Please use ASCII letters only (a-z) in this field.'],
    // 
    ['alphanum', function(v) {
      return Vanadium.validators_types['empty'].test(v) || !/\W/.test(v)
    }, 'Utilice solo letras (a-z) o números (0-9) solo en este campo. No se permiten espacios ni otros personajes.'],
    //
    ['date', function(v) {
      var test = new Date(v);
      return Vanadium.validators_types['empty'].test(v) || !isNaN(test);
    }, 'Please enter a valid date.'],
    //
    ['email', function (v) {
      return (Vanadium.validators_types['empty'].test(v)
              ||
              /\w{1,}[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(v))
    }, 'Por favor ingrese una direccion valida. Por ejemplo fred@domain.com .'],
    //
    ['url', function (v) {
      return Vanadium.validators_types['empty'].test(v) || /^(http|https|ftp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\/?/i.test(v)
    }, 'Please enter a valid URL.'],
//

    //
     ['date_au', function(v) {
      if (Vanadium.validators_types['empty'].test(v)) return true;
      var regex = /^(\d{2})\/(\d{2})\/(\d{4})$/;
      if (!regex.test(v)) return false;
      var d = new Date(v.replace(regex, '$2/$1/$3'));
      return ( parseInt(RegExp.$2, 10) == (1 + d.getMonth()) ) && (parseInt(RegExp.$1, 10) == d.getDate()) && (parseInt(RegExp.$3, 10) == d.getFullYear() );
    }, 'Por favor use el siguiente formato: dd/mm/aaaa. Por ejemplo 17/03/2006.'],
    //
    ['currency_dollar', function(v) {
      // [$]1[##][,###]+[.##]
      // [$]1###+[.##]
      // [$]0.##
      // [$].##
      return Vanadium.validators_types['empty'].test(v) || /^\$?\-?([1-9]{1}[0-9]{0,2}(\,[0-9]{3})*(\.[0-9]{0,2})?|[1-9]{1}\d*(\.[0-9]{0,2})?|0(\.[0-9]{0,2})?|(\.[0-9]{1,2})?)$/.test(v)
    }, 'Please enter a valid $ amount. For example $100.00 .'],
    //
    ['selection', function(v, elm) {
      return elm.options ? elm.selectedIndex > 0 : !Vanadium.validators_types['empty'].test(v);
    }, 'Please make a selection'],
    //
    ['one_required',
      function (v, elm) {
        var options = jQuery('input[name="' + elm.name + '"]');
        return some(options, function(elm) {
          return getNodeAttribute(elm, 'value')
        });
      }, 'Please select one of the above options.'],
    //
    ['length',
      function (v, p) {
        if (p === undefined) {
          return true
        } else {
          return v.length == parseInt(p)
        }
        ;
      },
      function (_v, p) {
        return 'El valor debe tener <span class="' + Vanadium.config.message_value_class + '">' + p + '</span> digitos.'
      }
    ],
    //
    ['min_length',
      function (v, p) {
        if (p === undefined) {
          return true
        } else {
          return v.length >= parseInt(p)
        }
        ;
      },
      function (_v, p) {
        return 'El valor debe ser como minimo  <span class="' + Vanadium.config.message_value_class + '">' + p + '</span> digitos.'
      }
    ],
    ['max_length',
      function (v, p) {
        if (p === undefined) {
          return true
        } else {
          return v.length <= parseInt(p)
        }
        ;
      },
      function (_v, p) {
        return 'El valor debe ser como minimo <span class="' + Vanadium.config.message_value_class + '">' + p + '</span> digitos.'
      }
    ],
    ['same_as',
      function (v, p) {
        if (p === undefined) {
          return true
        } else {
          var exemplar = document.getElementById(p);
          if (exemplar)
            return v == exemplar.value;
          else
            return false;
        }
        ;
      },
      function (_v, p) {
        var exemplar = document.getElementById(p);
        if (exemplar)
          return 'The value should be the same as <span class="' + Vanadium.config.message_value_class + '">' + (jQuery(exemplar).attr('name') || exemplar.id) + '</span> .';
        else
          return 'There is no exemplar item!!!'
      },
      "",
      function(validation_instance) {
        var exemplar = document.getElementById(validation_instance.param);
        if (exemplar){
          jQuery(exemplar).bind('validate', function(){
            jQuery(validation_instance.element).trigger('validate');
          });
        }
      }
    ],
    ['ajax',
      function (v, p, validation_instance, decoration_context, decoration_callback) {
        if (Vanadium.validators_types['empty'].test(v)) return true;
        if (decoration_context && decoration_callback) {
          jQuery.getJSON(p, {value: v, id: validation_instance.element.id}, function(data) {
            decoration_callback.apply(decoration_context, [[data], true]);
          });
        }
        return true;
      }]
    ,
    ['format',
      function(v, p) {
        var params = p.match(/^\/(((\\\/)|[^\/])*)\/(((\\\/)|[^\/])*)$/);        
        if (params.length == 7) {
          var pattern = params[1];
          var attributes = params[4];
          try
          {
            var exp = new RegExp(pattern, attributes);
            return exp.test(v);
          }
          catch(err)
          {
            return false
          }
        } else {
          return false
        }
      },
      function (_v, p) {
        var params = p.split('/');
        if (params.length == 3 && params[0] == "") {
          return 'The value should match the <span class="' + Vanadium.config.message_value_class + '">' + p.toString() + '</span> pattern.';
        } else {
          return 'provided parameter <span class="' + Vanadium.config.message_value_class + '">' + p.toString() + '</span> is not valid Regexp pattern.';
        }
      }
    ]
  ])

  if (typeof(VanadiumCustomValidationTypes) !== "undefined" && VanadiumCustomValidationTypes) Vanadium.addValidatorTypes(VanadiumCustomValidationTypes);
};




//-------------------- vanadium-init.js -----------------------------

jQuery(document).ready(function () {
  if (typeof(VanadiumConfig) === "object" && VanadiumConfig) {
    Vanadium.each(VanadiumConfig, function(k, v) {
      Vanadium.config[k] = v;
    })
  }
  if (typeof(VanadiumRules) === "object" && VanadiumRules) {
    Vanadium.each(VanadiumRules, function(k, v) {
      Vanadium.rules[k] = v;
    })
  }
  Vanadium.init();
});
