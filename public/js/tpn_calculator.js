$(document).ready(function() {
    $('#tpn-print').click(function() {
        window.print();
    });
    // recipe_1
    $('input[name="wt"], input[name="plan_4"], input[name="plan_10"], input[name="recipe_10"]').on('change', function() {
        var wt = parseFloat($('input[name="wt"]').val());
        var plan_4 = parseFloat($('input[name="plan_4"]').val());
        var plan_10 = parseFloat($('input[name="plan_10"]').val());
        var recipe_10 = parseFloat($('input[name="recipe_10"]').val());
        var recipe_1_value = (wt * plan_4 * plan_10 * 100) / recipe_10;
        if ($.isNumeric(recipe_1_value)) {
            recipe_1_value = parseFloat(recipe_1_value);
            recipe_1_value = recipe_1_value.toFixed(2);
        } else {
            recipe_1_value = '';
        }
        $('input[name="recipe_1"]').val(recipe_1_value).trigger('change');
    });
    // recipe_2
    $('input[name="wt"], input[name="plan_7"], input[name="plan_10"]').on('change', function() {
        var wt = parseFloat($('input[name="wt"]').val());
        var plan_7 = parseFloat($('input[name="plan_7"]').val());
        var plan_10 = parseFloat($('input[name="plan_10"]').val());
        var recipe_2_value = (wt * plan_7 * plan_10) / 0.5;
        if ($.isNumeric(recipe_2_value)) {
            recipe_2_value = parseFloat(recipe_2_value);
            recipe_2_value = recipe_2_value.toFixed(2);
        } else {
            recipe_2_value = '';
        }
        $('input[name="recipe_2"]').val(recipe_2_value).trigger('change');
    });
    // recipe_3
    $('input[name="wt"], input[name="plan_8"], input[name="plan_10"]').on('change', function() {
        var wt = parseFloat($('input[name="wt"]').val());
        var plan_8 = parseFloat($('input[name="plan_8"]').val());
        var plan_10 = parseFloat($('input[name="plan_10"]').val());
        var recipe_3_value = (wt * plan_8 * plan_10) / 2;
        if ($.isNumeric(recipe_3_value)) {
            recipe_3_value = parseFloat(recipe_3_value);
            recipe_3_value = recipe_3_value.toFixed(2);
        } else {
            recipe_3_value = '';
        }
        $('input[name="recipe_3"]').val(recipe_3_value).trigger('change');
    });
    // recipe_4
    $('input[name="wt"], input[name="recipe_9"], input[name="plan_5"]').on('change', function() {
        var recipe_9 = parseFloat($('input[name="recipe_9"]').val());
        var plan_5 = parseFloat($('input[name="plan_5"]').val());
        var wt = parseFloat($('input[name="wt"]').val());
        var c23 = c_23(recipe_9);
        var recipe_4_value;
        if (c23 == 0) {
            recipe_4_value = 0;
        } else {
            if (plan_5 == 0) {
                recipe_4_value = 0;
            } else {
                recipe_4_value = wt + ((wt * 5) / c23);
            }
        }
        if ($.isNumeric(recipe_4_value)) {
            recipe_4_value = parseFloat(recipe_4_value);
            recipe_4_value = recipe_4_value.toFixed(2);
        } else {
            recipe_4_value = 0;
        }
        $('input[name="recipe_4"]').val(recipe_4_value).trigger('change');
    });
    // recipe_5
    $('input[name="wt"], input[name="plan_9"], input[name="plan_10"]').on('change', function() {
        var wt = parseFloat($('input[name="wt"]').val());
        var plan_9 = parseFloat($('input[name="plan_9"]').val());
        var plan_10 = parseFloat($('input[name="plan_10"]').val());
        var recipe_5_value = wt * plan_9 * plan_10;
        if ($.isNumeric(recipe_5_value)) {
            recipe_5_value = parseFloat(recipe_5_value);
            recipe_5_value = recipe_5_value.toFixed(2);
        } else {
            recipe_5_value = '';
        }
        $('input[name="recipe_5"]').val(recipe_5_value).trigger('change');
    });
    // recipe_6
    $('input[name="wt"], input[name="plan_10"]').on('change', function() {
        var wt = parseFloat($('input[name="wt"]').val());
        var plan_10 = parseFloat($('input[name="plan_10"]').val());
        var recipe_6_value = 0.25 * wt * plan_10;
        if ($.isNumeric(recipe_6_value)) {
            recipe_6_value = parseFloat(recipe_6_value);
            recipe_6_value = recipe_6_value.toFixed(2);
        } else {
            recipe_6_value = '';
        }
        $('input[name="recipe_6"]').val(recipe_6_value).trigger('change');
    });
    // recipe_7
    $('input[name="wt"], input[name="plan_1"], input[name="plan_2"], input[name="plan_3"], input[name="plan_6"], input[name="plan_10"], input[name="recipe_1"], input[name="recipe_2"], input[name="recipe_3"], input[name="recipe_5"], input[name="recipe_6"], input[name="recipe_8"], input[name="recipe_9"]').on('change', function() {
        var wt = parseFloat($('input[name="wt"]').val());
        var plan_1 = parseFloat($('input[name="plan_1"]').val());
        var plan_2 = parseFloat($('input[name="plan_2"]').val());
        var plan_3 = parseFloat($('input[name="plan_3"]').val());
        var plan_6 = parseFloat($('input[name="plan_6"]').val());
        var plan_10 = parseFloat($('input[name="plan_10"]').val());
        var recipe_1 = parseFloat($('input[name="recipe_1"]').val());
        var recipe_2 = parseFloat($('input[name="recipe_2"]').val());
        var recipe_3 = parseFloat($('input[name="recipe_3"]').val());
        var recipe_5 = parseFloat($('input[name="recipe_5"]').val());
        var recipe_6 = parseFloat($('input[name="recipe_6"]').val());
        var recipe_8 = parseFloat($('input[name="recipe_8"]').val());
        var recipe_9 = parseFloat($('input[name="recipe_9"]').val());
        var c19 = c_19(wt, plan_1, plan_2, plan_3);
        var c23 = c_23(recipe_9);
        var c21 = c_21(plan_6, wt);        
        var c20 = c_20(c19, c23);
        var f19 = f_19(recipe_1, recipe_2, recipe_3, recipe_5, recipe_6);
        var f20 = f_20(c19, c20, plan_10, f19);
        var recipe_7_value;
        if (c21 == 0) {
            recipe_7_value = 0;
        } else {
            recipe_7_value = f20 - recipe_8;
        }
        if ($.isNumeric(recipe_7_value)) {
            recipe_7_value = parseFloat(recipe_7_value);
            recipe_7_value = recipe_7_value.toFixed(2);
        } else {
            recipe_7_value = 0;
        }
        $('input[name="recipe_7"]').val(recipe_7_value).trigger('change');
    });
    // recipe_8
    $('input[name="wt"], input[name="plan_1"], input[name="plan_2"], input[name="plan_3"], input[name="plan_6"], input[name="plan_10"], input[name="recipe_1"], input[name="recipe_2"], input[name="recipe_3"], input[name="recipe_5"], input[name="recipe_6"], input[name="recipe_9"]').on('change', function() {
        var wt = parseFloat($('input[name="wt"]').val());
        var plan_1 = parseFloat($('input[name="plan_1"]').val());
        var plan_2 = parseFloat($('input[name="plan_2"]').val());
        var plan_3 = parseFloat($('input[name="plan_3"]').val());
        var plan_6 = parseFloat($('input[name="plan_6"]').val());
        var plan_10 = parseFloat($('input[name="plan_10"]').val());
        var recipe_1 = parseFloat($('input[name="recipe_1"]').val());
        var recipe_2 = parseFloat($('input[name="recipe_2"]').val());
        var recipe_3 = parseFloat($('input[name="recipe_3"]').val());
        var recipe_5 = parseFloat($('input[name="recipe_5"]').val());
        var recipe_6 = parseFloat($('input[name="recipe_6"]').val());
        var recipe_9 = parseFloat($('input[name="recipe_9"]').val());
        var c21 = c_21(plan_6, wt);
        var c23 = c_23(recipe_9);
        var c19 = c_19(wt, plan_1, plan_2, plan_3);
        var c20 = c_20(c19, c23);
        var f19 = f_19(recipe_1, recipe_2, recipe_3, recipe_5, recipe_6);
        var f20 = f_20(c19, c20, plan_10, f19);
        var d13 = 25;
        var recipe_8_value;
        if (c21 == 0) {
            recipe_8_value = 0;
        } else {
            recipe_8_value = ((c21 * plan_10 * 10) - f20) * 10 / (d13 - 10);
        }
        if ($.isNumeric(recipe_8_value)) {
            recipe_8_value = parseFloat(recipe_8_value);
            recipe_8_value = recipe_8_value.toFixed(2);
        } else {
            recipe_8_value = '';
        }
        $('input[name="recipe_8"]').val(recipe_8_value).trigger('change');
    });
    // recipe_9
    $('input[name="wt"], input[name="plan_5"], input[name="recipe_11"]').on('change', function() {
        var wt = parseFloat($('input[name="wt"]').val());
        var plan_5 = parseFloat($('input[name="plan_5"]').val());
        var recipe_11 = parseFloat($('input[name="recipe_11"]').val());
        var recipe_9_value;
        if (plan_5 == 0) {
            recipe_9_value = 0;
        } else {
            recipe_9_value = wt * plan_5 * 100 / recipe_11 + 5;
        }
        if ($.isNumeric(recipe_9_value)) {
            recipe_9_value = parseFloat(recipe_9_value);
            recipe_9_value = recipe_9_value.toFixed(2);
        } else {
            recipe_9_value = '';
        }
        $('input[name="recipe_9"]').val(recipe_9_value).trigger('change');
    });
    // plan_12
    $('input[name="wt"], input[name="plan_1"], input[name="plan_2"], input[name="plan_3"], input[name="plan_6"], input[name="plan_10"], input[name="recipe_1"], input[name="recipe_2"], input[name="recipe_3"], input[name="recipe_5"], input[name="recipe_6"], input[name="recipe_9"]').on('change', function() {
        var wt = parseFloat($('input[name="wt"]').val());
        var plan_1 = parseFloat($('input[name="plan_1"]').val());
        var plan_2 = parseFloat($('input[name="plan_2"]').val());
        var plan_3 = parseFloat($('input[name="plan_3"]').val());
        var plan_6 = parseFloat($('input[name="plan_6"]').val());
        var plan_10 = parseFloat($('input[name="plan_10"]').val());
        var recipe_1 = parseFloat($('input[name="recipe_1"]').val());
        var recipe_2 = parseFloat($('input[name="recipe_2"]').val());
        var recipe_3 = parseFloat($('input[name="recipe_3"]').val());
        var recipe_5 = parseFloat($('input[name="recipe_5"]').val());
        var recipe_6 = parseFloat($('input[name="recipe_6"]').val());
        var recipe_9 = parseFloat($('input[name="recipe_9"]').val());
        var f19 = f_19(recipe_1, recipe_2, recipe_3, recipe_5, recipe_6);
        var c21 = c_21(plan_6, wt);
        var c23 = c_23(recipe_9);
        var c19 = c_19(wt, plan_1, plan_2, plan_3);
        var c20 = c_20(c19, c23);
        var f20 = f_20(c19, c20, plan_10, f19);
        var f21;
        if (f20 == 0) {
            f21 = 0;
        } else {
            if (f19 == 0 && f20 == 0) {
                f21 = 'NA';
            } else {
                f21 = ((c21 * plan_10) / (f19 + f20)) * 100
            }
        }
        var plan_12_value = f21;
        if ($.isNumeric(plan_12_value)) {
            plan_12_value = parseFloat(plan_12_value);
            plan_12_value = plan_12_value.toFixed(2);
        } else {
            plan_12_value = '';
        }
        $('input[name="plan_12"]').val(plan_12_value);
    });
    // recipe_12
    $('input[name="plan_1"], input[name="plan_4"], input[name="plan_5"], input[name="plan_6"]').on('change', function() {
        var plan_1 = parseFloat($('input[name="plan_1"]').val());
        var plan_4 = parseFloat($('input[name="plan_4"]').val());
        var plan_5 = parseFloat($('input[name="plan_5"]').val());
        var plan_6 = parseFloat($('input[name="plan_6"]').val());
        var recipe_12_value;
        if (plan_1 == 0) {
            recipe_12_value = 0;
        } else {
            recipe_12_value = (plan_4 * 4) + (plan_5 * 10) + (plan_6 * 1.44 * 3.4);
        }
        if ($.isNumeric(recipe_12_value)) {
            recipe_12_value = parseFloat(recipe_12_value);
            recipe_12_value = recipe_12_value.toFixed(2);
        } else {
            recipe_12_value = '';
        }
        $('input[name="recipe_12"]').val(recipe_12_value).trigger('change');
    });
    // plan_13
    $('input[name="plan_5"], input[name="recipe_9"], input[name="recipe_12"]').on('change', function() {
        var plan_5 = parseFloat($('input[name="plan_5"]').val());
        var recipe_9 = parseFloat($('input[name="recipe_9"]').val());
        var recipe_12 = parseFloat($('input[name="recipe_12"]').val());
        var c23 = c_23(recipe_9);
        var plan_13_value;
        if (c23 == 0) {
            plan_13_value = 0;
        } else {
            if (recipe_12 == 0) {
                plan_13_value = 'NA';
            } else {
                plan_13_value = (plan_5 * 10) / recipe_12;
            }
        }
        if ($.isNumeric(plan_13_value)) {
            plan_13_value = parseFloat(plan_13_value);
            plan_13_value = plan_13_value * 100;
            plan_13_value = plan_13_value.toFixed(2);
        } else {
            plan_13_value = '';
        }
        $('input[name="plan_13"]').val(plan_13_value);
    });
    // recipe_13
    $('input[name="plan_4"], input[name="recipe_12"]').on('change', function() {
        var plan_4 = parseFloat($('input[name="plan_4"]').val());
        var recipe_12 = parseFloat($('input[name="recipe_12"]').val());
        var recipe_13_value;
        if (recipe_12 == 0) {
            recipe_13_value = 0;
        } else {
            if (plan_4 == 0) {
                recipe_13_value = 'NA';
            } else {
                recipe_13_value = recipe_12 / plan_4;
            }
        }
        if ($.isNumeric(recipe_13_value)) {
            recipe_13_value = parseFloat(recipe_13_value);
            recipe_13_value = recipe_13_value.toFixed(2);
        } else {
            recipe_13_value = '';
        }
        $('input[name="recipe_13"]').val(recipe_13_value);
    });
    // plan_14, recipe_14
    $('input[name="wt"], input[name="plan_1"], input[name="plan_2"], input[name="plan_3"], input[name="recipe_9"]').on('change', function() {
        var wt = parseFloat($('input[name="wt"]').val());
        var plan_1 = parseFloat($('input[name="plan_1"]').val());
        var plan_2 = parseFloat($('input[name="plan_2"]').val());
        var plan_3 = parseFloat($('input[name="plan_3"]').val());
        var recipe_9 = parseFloat($('input[name="recipe_9"]').val());
        var c19 = c_19(wt, plan_1, plan_2, plan_3);
        var c23 = c_23(recipe_9);
        var c20 = c_20(c19, c23); 
        var plan_14_value;
        if (c20 < 0) {
            plan_14_value = 'NA';
        } else {
            plan_14_value = c20 / 24;
        }
        if (plan_14_value != 'NA') {
            if ($.isNumeric(plan_14_value)) {
                plan_14_value = parseFloat(plan_14_value);
                var plan_14 = plan_14_value.toPrecision(2);
                plan_14_value = plan_14_value.toFixed(2);
            } else {
                plan_14_value = '';
            }
        } else {
            var plan_14 = plan_14_value;
        }
        $('#plan_14').html(plan_14);
        var recipe_14_value = plan_14_value;
        $('#recipe_14').html(recipe_14_value+')');
    });
    // plan_15, recipe_15
    $('input[name="wt"], input[name="plan_5"], input[name="recipe_9"]').on('change', function() {
        var wt = parseFloat($('input[name="wt"]').val());
        var recipe_9 = parseFloat($('input[name="recipe_9"]').val());
        var plan_5 = parseFloat($('input[name="plan_5"]').val());
        var plan_15_value;
        if (plan_5 == 0) {
            plan_15_value = 0;
        } else {
            plan_15_value = ((recipe_9 - 5) + wt ) / 24;
        }
        if ($.isNumeric(plan_15_value)) {
            plan_15_value = parseFloat(plan_15_value);
            var plan_15 = plan_15_value.toPrecision(2);
            plan_15_value = plan_15_value.toFixed(2);
        } else {
            plan_15_value = '';
        }
        $('#plan_15').html(plan_15);
        var recipe_15_value = plan_15_value;
        $('#recipe_15').html(recipe_15_value+')');        
    });
    function c_19(wt, plan_1, plan_2, plan_3) {
        var wt = parseFloat(wt);
        var plan_1 = parseFloat(plan_1);
        var plan_2 = parseFloat(plan_2);
        var plan_3 = parseFloat(plan_3);
        return plan_1 * wt - (plan_2 * wt) - plan_3;
    }
    function c_20(c19, c23) {
        var c19 = parseFloat(c19);
        var c23 = parseFloat(c23);
        if (c19 == 0) {
            return 0;
        } else {
            return c19 - c23;
        }
    }
    function c_21(plan_6, wt) {
        var plan_6 = parseFloat(plan_6);
        var wt = parseFloat(wt);
        return plan_6 * wt * 1.44;
    }
    function c_23(recipe_9) {
        var recipe_9 = parseFloat(recipe_9);
        if (recipe_9 == 0) {
            return 0;
        } else {
            return recipe_9 - 5;
        }
    }
    function f_19(recipe_1, recipe_2, recipe_3, recipe_5, recipe_6) {
        return parseFloat(recipe_1) + parseFloat(recipe_2) + parseFloat(recipe_3) + parseFloat(recipe_5) + parseFloat(recipe_6);
    }
    function f_20(c19, c20, plan_10, f19) {        
        var c19 = parseFloat(c19);
        var c20 = parseFloat(c20);
        var plan_10 = parseFloat(plan_10);
        var f19 = parseFloat(f19);
        if (c19 == 0) {
            return 0;
        } else {
            return (c20 * plan_10) - f19;
        }
    }
});
var site_base_url = $('input[name="site_base_url"]').val();
$(document).on('change', '#ssearch', function() {
    var value = $(this).val();
    var label_content = $(this).parents().find('.select2-chosen').html();
    $('#baby-tag').html(label_content);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: site_base_url + '/get-latest-weight/' + value,
        success: function(response) {
            var weight = response.prev_wt / 1000;
            $('input[name="wt"]').val(weight).trigger('change');
        }
    });
});
