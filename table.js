/* global statsfc_lang */

var $j = jQuery;

function StatsFC_Table (key) {
  this.referer = '';
  this.key = key;
  this.competition = 'EPL';
  this.group = '';
  this.season = '';
  this.rows = 0;
  this.date = '';
  this.tableType = 'full';
  this.highlight = '';
  this.showBadges = false;
  this.showForm = false;
  this.showStatus = false;
  this.omitErrors = false;
  this.useDefaultCss = false;
  this.lang = 'en';

  this.translate = function (key) {
    if (
      typeof statsfc_lang === 'undefined' ||
      typeof statsfc_lang[key] === 'undefined' ||
      statsfc_lang[key].length === 0
    ) {
      return key;
    }

    return statsfc_lang[key];
  };

  this.display = function (placeholder) {
    this.loadLang('statsfc-lang', this.lang);

    var $placeholder;

    switch (typeof placeholder) {
      case 'string':
        $placeholder = $j('#' + placeholder);
        break;
      case 'object':
        $placeholder = placeholder;
        break;
      default:
        return;
    }

    if ($placeholder.length === 0) {
      return;
    }

    if (this.useDefaultCss === true || this.useDefaultCss === 'true') {
      this.loadCss('statsfc-table-css');
    }

    if (typeof this.referer !== 'string' || this.referer.length === 0) {
      this.referer = window.location.hostname;
    }

    var $container = $j('<div>').addClass('sfc_table');

    // Store globals variables here so we can use it later.
    var tableType = this.tableType;
    var highlight = this.highlight;
    var showBadges = (this.showBadges === true || this.showBadges === 'true');
    var showForm = (this.showForm === true || this.showForm === 'true');
    var showStatus = (this.showStatus === true || this.showStatus === 'true');
    var omitErrors = (this.omitErrors === true || this.omitErrors === 'true');
    var translate = this.translate;
    var getGroups = this.getGroups;

    $j.getJSON(
      'https://widgets.statsfc.com/api/standings.json?callback=?',
      {
        key: this.key,
        domain: this.referer,
        competition: this.competition,
        group: this.group,
        season: this.season,
        highlight: this.highlight,
        rows: this.rows,
        date: this.date,
        showForm: this.showForm,
      },
      function (data) {
        if (data.error) {
          if (omitErrors) {
            return;
          }

          var $error = $j('<p>').css('text-align', 'center');

          if (data.customer && data.customer.attribution) {
            $error.append(
              $j('<a>').attr({
                href: 'https://statsfc.com',
                title: 'Football widgets and API',
                target: '_blank',
              }).text('Stats FC'),
              ' – ',
            );
          }

          $error.append(translate(data.error));

          $container.append($error);

          return;
        }

        var groups = getGroups(data.table);

        if (groups.length === 0) {
          groups.push(null);
        }

        groups.forEach(function (group) {
          if (groups.length > 1 && group.length) {
            $container.append($j('<p>').text(group));
          }

          var $table = $j('<table>');
          var $thead = $j('<thead>');
          var $tbody = $j('<tbody>');

          var $position = $j('<th>').addClass('sfc_numeric').append(
            $j('<abbr>').attr('title', translate('Position')).text(translate('Pos')),
          );

          var $status = (showStatus ? $j('<th>') : '');

          var $team = $j('<th>').text(translate('Team'));

          if (showBadges) {
            $team.addClass('sfc_team');
          }

          var $played = $j('<th>').addClass('sfc_numeric').append(
            $j('<abbr>').attr('title', translate('Matches played')).text(translate('P')),
          );

          var $goal_difference = $j('<th>').addClass('sfc_numeric').append(
            $j('<abbr>').attr('title', translate('Goal difference')).text(translate('GD')),
          );

          var $points = $j('<th>').addClass('sfc_numeric').append(
            $j('<abbr>').attr('title', translate('Points')).text(translate('Pts')),
          );

          if (tableType === 'full') {
            $thead.append(
              $j('<tr>').append(
                $position,
                $status,
                $team,
                $played,
                $j('<th>').addClass('sfc_numeric').append(
                  $j('<abbr>').attr('title', translate('Matches won')).text(translate('W')),
                ),
                $j('<th>').addClass('sfc_numeric').append(
                  $j('<abbr>').attr('title', translate('Matches drawn')).text(translate('D')),
                ),
                $j('<th>').addClass('sfc_numeric').append(
                  $j('<abbr>').attr('title', translate('Matches lost')).text(translate('L')),
                ),
                $j('<th>').addClass('sfc_numeric').append(
                  $j('<abbr>').attr('title', translate('Goals for')).text(translate('GF')),
                ),
                $j('<th>').addClass('sfc_numeric').append(
                  $j('<abbr>').attr('title', translate('Goals against')).text(translate('GA')),
                ),
                $goal_difference,
                $points,
              ),
            );
          } else {
            $thead.append(
              $j('<tr>').append(
                $position,
                $status,
                $team,
                $played,
                $goal_difference,
                $points,
              ),
            );
          }

          if (showForm) {
            $thead.find('tr').append(
              $j('<th>').text(translate('Form')),
            );
          }

          if (data.table.length > 0) {
            $j.each(data.table, function (key, val) {
              if (val.group !== group) {
                return;
              }

              var $row = $j('<tr>');

              if (typeof val.info === 'string' && val.info.length > 0) {
                $row.addClass('sfc_' + val.info);
              }

              if (highlight === val.team || highlight === val.teamfull) {
                $row.addClass('sfc_highlight');
              }

              var $position = $j('<td>').addClass('sfc_numeric').text(val.pos);
              var $status = (showStatus ? $j('<td>').append($j('<i>').addClass('sfc_movement sfc_movement_' + val.status)) : '');
              var $team = $j('<td>').addClass('sfc_badge_' + val.path).text(val.team);
              var $played = $j('<td>').addClass('sfc_numeric').text(val.p);
              var $goal_difference = $j('<td>').addClass('sfc_numeric').text(val.gd);
              var $points = $j('<td>').addClass('sfc_numeric').text(val.pts);

              if (showBadges) {
                $team.addClass('sfc_team').css('background-image', 'url(https://cdn.statsfc.com/kit/' + val.shirt + ')');
              }

              if (tableType === 'full') {
                $row.append(
                  $position,
                  $status,
                  $team,
                  $played,
                  $j('<td>').addClass('sfc_numeric').text(val.w),
                  $j('<td>').addClass('sfc_numeric').text(val.d),
                  $j('<td>').addClass('sfc_numeric').text(val.l),
                  $j('<td>').addClass('sfc_numeric').text(val.gf),
                  $j('<td>').addClass('sfc_numeric').text(val.ga),
                  $goal_difference,
                  $points,
                );
              } else {
                $row.append(
                  $position,
                  $status,
                  $team,
                  $played,
                  $goal_difference,
                  $points,
                );
              }

              if (showForm) {
                var $form = $j('<td>').addClass('sfc_form');

                $j.each(val.form, function (key, match) {
                  $form.append(
                    $j('<span>').addClass('sfc_form sfc_' + match).text('\xA0'),
                  );
                });

                $row.append($form);
              }

              $tbody.append($row);
            });

            $table.append($thead, $tbody);
          }

          $container.append($table);
        });

        if (data.customer.attribution) {
          $container.append(
            $j('<div>').attr('class', 'sfc_footer').append(
              $j('<p>').append(
                $j('<small>').append('Powered by ').append(
                  $j('<a>').attr({
                    href: 'https://statsfc.com',
                    title: 'StatsFC – Football widgets',
                    target: '_blank',
                  }).text('StatsFC.com'),
                ),
              ),
            ),
          );
        }
      },
    );

    $placeholder.append($container);
  };

  this.getGroups = function (data) {
    var groups = [];

    $j.each(data, function (key, val) {
      if (groups.indexOf(val.group) === -1) {
        groups.push(val.group);
      }
    });

    return groups;
  };

  this.loadCss = function (id) {
    if (document.getElementById(id)) {
      return;
    }

    var css, fcss = (document.getElementsByTagName('link')[0] || document.getElementsByTagName('script')[0]);

    css = document.createElement('link');
    css.id = id;
    css.rel = 'stylesheet';
    css.href = 'https://cdn.statsfc.com/css/table.css';

    fcss.parentNode.insertBefore(css, fcss);
  };

  this.loadLang = function (id, l) {
    if (document.getElementById(id)) {
      return;
    }

    var lang, flang = document.getElementsByTagName('script')[0];

    lang = document.createElement('script');
    lang.id = id;
    lang.src = 'https://cdn.statsfc.com/js/lang/' + l + '.js';

    flang.parentNode.insertBefore(lang, flang);
  };
}

/**
 * Load widgets dynamically using data-* attributes
 */
$j('div.statsfc-table').each(function () {
  var key = $j(this).attr('data-key'),
    table = new StatsFC_Table(key),
    data = $j(this).data();

  for (var i in data) {
    table[i] = data[i];
  }

  table.display($j(this));
});
