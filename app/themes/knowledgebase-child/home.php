<?php
/**
 * Dynamic Homepage
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package iPanelThemes Knowledgebase
 */

get_header(); ?>

  <div id="primary" class="content-area row">
    <main id="main" class="site-main" role="main">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              <a href="/category/developer-resources/">
                Editor Resources
              </a>
            </h3>
          </div>
          <div class="panel-body">
            <?php
              loop_through_categories('editor-resources')
            ?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              <a href="/category/developer-resources/">
                Developer Resources
              </a>
            </h3>
          </div>
          <div class="panel-body">
            <?php
              loop_through_categories('developer-resources')
            ?>
          </div>
        </div>
      </div>
    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_footer(); ?>
