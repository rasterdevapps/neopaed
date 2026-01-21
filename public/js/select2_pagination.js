    // Function to shuffle the demo data
    function shuffle(str) {
        return str.split('').sort(function() {
            return 0.5 - Math.random();
        }).join('');
    }
    // For demonstration purposes we first make
    // a huge array of demo data (20 000 items)
    // HEADS UP; for the _.map function i use underscore (actually lo-dash) here
    function mockData() {
        var raw_data = $('input[name="select_field_data"]').val();
        raw_data = JSON.parse(raw_data);
        var count = raw_data.length;
        return _.map(_.range(0, count), function(i) {
            var data = raw_data[i].split('||');
            var encrypted_id = data[0];
            var baby_name = data[1];
            return {
                id: encrypted_id,
                text: baby_name,
            };
        });
    }
    (function() {
        // init select 2
        $('#ssearch').select2({
            data: mockData(),
            placeholder: 'search',
            // query with pagination
            query: function(q) {
                var pageSize,
                    results,
                    that = this;
                pageSize = 20; // or whatever pagesize
                results = [];
                if (q.term && q.term !== '') {
                    // HEADS UP; for the _.filter function i use underscore (actually lo-dash) here
                    results = _.filter(that.data, function(e) {
                        return e.text.toUpperCase().indexOf(q.term.toUpperCase()) >= 0;
                    });
                } else if (q.term === '') {
                    results = that.data;
                }
                q.callback({
                    results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
                    more: results.length >= q.page * pageSize,
                });
            }, 
            createSearchChoice:function(term, data) {
                if ($('input[name="tags"]').val()) {
                    if ($(data).filter(function() {
                        return this.text.localeCompare(term) === 0;
                    }).length === 0) {
                        return {id:term, text:term};
                    }
                }
            },
        });
    })();
    $(document).ready(function() {
        $(".submitbtn, .submittbtn").attr('disabled', true);
        $("#ssearch").on('change', function() {
            $(".submitbtn, .submittbtn").attr('disabled', false);
        });
    });
