"use strict";

/* eslint-disable yoda */

/* RADIO PUBLIC CLASS DEFINITION
 * ============================== */
UW.Radio = Backbone.View.extend({
  states: {
    checked: 'checked',
    disabled: 'disabled'
  },
  events: {
    'click input': 'toggle'
  },
  initialize: function initialize(options) {
    _.bindAll(this, 'toggle', 'getGroup', 'toggleCheckBox');

    this.settings = _.extend({}, this.defaults, this.$el.data(), options);
    this.$input = this.$el;
    this.name = this.$el.attr('name');
    this.setElement(this.$el.closest('label'));
    this.setState();
  },
  setState: function setState() {
    if (this.$input.prop(this.states.disabled)) {
      this.$el.addClass(this.states.disabled);
    }

    if (this.$input.prop(this.states.checked)) {
      this.$el.addClass(this.states.checked);
    }
  },
  getGroup: function getGroup() {
    if (this.$input.attr('type') === 'radio') {
      return _.where(UW.radio, {
        name: this.name
      });
    }

    if (this.$input.attr('type') === 'checkbox') {
      return _.where(UW.checkbox, {
        name: this.name
      });
    }
  },
  toggle: function toggle(e) {
    _.each(this.getGroup(), this.toggleCheckBox);
  },
  toggleCheckBox: function toggleCheckBox(view) {
    var checked = view.$input.prop(this.states.checked);
    var disabled = view.$input.prop(this.states.disabled);

    if (!disabled && view.$el.removeClass(this.states.checked)) {
      view.$el.removeAttr(this.states.checked).trigger('change');
    }

    if (!disabled) {
      if (checked && view.$el.addClass(this.states.checked)) {
        view.$el.trigger($.Event('toggle'));
      }

      if (checked !== view.$el.prop(this.states.checked)) {
        view.$el.trigger('change');
      }
    }
  }
});