({

    'events': {
    },
    /**
     * Called when initializing the field
     * @param options
     */


    initialize: function(options) {

        this._super('initialize', [options]);
        var add_handler_name = "change [name='"+ this.name +"']";
        var add_events = {};
        add_events[add_handler_name] = 'updateAddress';
        this.events = _.extend({}, this.events, options.def.events, add_events);
    },

    updateAddress: function() {
        var adr_postalcode = this.model.get(this.name);
        var adr_state_name = this.name.replace('_postalcode','_state');
        var adr_city_name = this.name.replace('_postalcode','_city');
        var adr_street_name = this.name.replace('_postalcode','_street');
        var adr_country_name = this.name.replace('_postalcode','_country');


        if (_.isEmpty(adr_postalcode)) {
            return;
        }
        var self = this;
        var user_lang = app.lang.getLanguage() || "en_us";
        console.log(user_lang);
        if(user_lang == 'ja_JP'){

            var adr_postalcode = adr_postalcode.match(/\d/g).join("");
            if (adr_postalcode.length != 7) {
                return;
            }

            var apiUrl = app.api.buildURL('ZipToAddress',null,null,{type:'japanese',zip:adr_postalcode});
            console.log(apiUrl);
            app.api.call('get', apiUrl, null,{

                success: function (data) {
                    if (_.isEmpty(data['results'])) {
                        return;
                    }
                    var setResult = {};
                    if (!_.isEmpty(data['results'][0]['address1'])) {
                        setResult[adr_state_name] = data['results'][0]['address1'];
                    }
                    if (!_.isEmpty(data['results'][0]['address2'])) {
                        setResult[adr_city_name] = data['results'][0]['address2'];
                    }
                    if (!_.isEmpty(data['results'][0]['address3'])) {
                        setResult[adr_street_name] = data['results'][0]['address3'];
                    }
                    self.model.set(setResult);
                }
            });
            // Can't use https below
            //$.ajax({
            //    url: 'http://zipcloud.ibsnet.co.jp/api/search?zipcode=' +
            //    adr_postalcode,
            //    dataType: 'jsonp',
            //    success: function (data) {
            //        if (_.isEmpty(data['results'])) {
            //            return;
            //        }
            //        var setResult = {};
            //        if (!_.isEmpty(data['results'][0]['address1'])) {
            //            setResult[adr_state_name] = data['results'][0]['address1'];
            //        }
            //        if (!_.isEmpty(data['results'][0]['address2'])) {
            //            setResult[adr_city_name] = data['results'][0]['address2'];
            //        }
            //        if (!_.isEmpty(data['results'][0]['address3'])) {
            //            setResult[adr_street_name] = data['results'][0]['address3'];
            //        }
            //        self.model.set(setResult);
            //    }
            //});
        } else {
            var countryCode;
            if(!_.isEmpty(this.model.get(adr_country_name)) && this.model.get(adr_country_name).length == 2) {
                countryCode = this.model.get(adr_country_name);
            } else if (user_lang == 'en_UK') {
                countryCode = "GB";
            } else {
                countryCode = user_lang.slice(-2);
            }

            var apiUrl = app.api.buildURL('ZipToAddress',null,null,{type:'global',zip:adr_postalcode, CC:countryCode});
            app.api.call('get', apiUrl, null,{

                success: function (data) {
                    if (_.isEmpty(data)) {
                        return;
                    }
                    var setResult = {};
                    if (!_.isEmpty(data['places'][0]['state'])) {
                        setResult[adr_state_name] = data['places'][0]['state'];
                    }
                    if (!_.isEmpty(data['places'][0]['place name'])) {
                        setResult[adr_city_name] = data['places'][0]['place name'];
                    }
                    if (!_.isEmpty(data['country abbreviation'])) {
                        setResult[adr_country_name] = data['country abbreviation'];
                    }
                    self.model.set(setResult);
                }
            });

            // Can't use https below
            //$.ajax({
            //    url: 'http://api.zippopotam.us/' +
            //    countryCode + '/' + adr_postalcode,
            //    success: function (data) {
            //        if (_.isEmpty(data)) {
            //            return;
            //        }
            //        var setResult = {};
            //        if (!_.isEmpty(data['places'][0]['state'])) {
            //            setResult[adr_state_name] = data['places'][0]['state'];
            //        }
            //        if (!_.isEmpty(data['places'][0]['place name'])) {
            //            setResult[adr_city_name] = data['places'][0]['place name'];
            //        }
            //        if (!_.isEmpty(data['country abbreviation'])) {
            //            setResult[adr_country_name] = data['country abbreviation'];
            //        }
            //
            //        self.model.set(setResult);
            //    }
            //});
        }

    }
})