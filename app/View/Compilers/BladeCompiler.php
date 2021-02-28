<?php

namespace App\View\Compilers;

use Illuminate\View\Compilers\BladeCompiler as BaseBladeCompiler;

class BladeCompiler extends BaseBladeCompiler
{
    /**
     * Compile the view at the given path.
     *
     * @param  string|null  $path
     * @return void
     */
    public function compile($path = null)
    {
        if ($path) {
            $this->setPath($path);
        }

        if (! is_null($this->cachePath)) {
            $contents = '';

            if (app()->isLocal() && ! empty($this->getPath())) {
                $contents .= "<?php /** {$this->getPath()} **/ ?>";
            }

            $contents .= $this->render(
                $this->compileString(
                    $this->files->get($this->getPath())
                )
            );

            $this->files->put(
                $this->getCompiledPath($this->getPath()), $contents
            );
        }
    }

    /**
     * Get the minified value.
     *
     * See the original here: https://stackoverflow.com/questions/5312349/minifying-final-html-output-using-regular-expressions-with-codeigniter
     *
     * @param string $html
     *
     * @return string
     */
    public function render($html)
    {
        if (!config('view.minified'))
            return $html;

        $replace = '%   # Collapse whitespace everywhere but in blacklisted elements.
        (?>          # Match all whitespans other than single space.
          [^\S ]\s*  # Either one [\t\r\n\f\v] and zero or more ws,
        | \s{2,}        # or two or more consecutive-any-whitespace.
        )              # Note: The remaining regex consumes no text at all...
        (?=          # Ensure we are not in a blacklist tag.
          [^<]*+        # Either zero or more non-"<" {normal*}
          (?:          # Begin {(special normal*)*} construct
            <          # or a < starting a non-blacklist tag.
            (?!/?(?:textarea|pre|script)\b)
            [^<]*+    # more non-"<" {normal*}
          )*+          # Finish "unrolling-the-loop"
          (?:          # Begin alternation group.
            <          # Either a blacklist start tag.
            (?>textarea|pre|script)\b
          | \z        # or end of file.
          )          # End alternation group.
        )              # If we made it here, we are not in a blacklist tag.
        %Six';

        $html = preg_replace($replace, " ", $html);

        // Remove all whitespace
        $html = preg_replace('/\>\s+\</m', '><', $html);

        return $html;
    }
}
