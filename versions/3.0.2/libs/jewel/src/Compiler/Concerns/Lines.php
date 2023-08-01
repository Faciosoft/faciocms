<?php
    namespace Jewel\Compiler\Concerns;

    trait Lines {
        public function ParseContentTagExpr(string $line_buffer): string {
            return preg_replace_callback(JEWEL_CONTENT_TAG_REGEX, function($tags) {
                foreach($tags as $tag) {
                    $tag = substr($tag, 1, strlen($tag) - 2);
                    return "<?php echo $tag; ?>";
                }
            }, $line_buffer);
        }

        public function ParseIfTagExpr(string $line_buffer): string {
            return preg_replace_callback(JEWEL_IF_TAG_REGEX, function($tags) {
                foreach($tags as $tag) {
                    $tag = substr($tag, 3, strlen($tag) - 3);
                    return "<?php if$tag: ?>";
                }
            }, $line_buffer);
        }

        public function ParseElseIfTagExpr(string $line_buffer): string {
            return preg_replace_callback(JEWEL_ELSEIF_TAG_REGEX, function($tags) {
                foreach($tags as $tag) {
                    $tag = substr($tag, 7, strlen($tag) - 7);
                    return "<?php elseif$tag: ?>";
                }
            }, $line_buffer);
        }

        public function ParseForeachTagExpr(string $line_buffer): string {
            return preg_replace_callback(JEWEL_FOREACH_TAG_REGEX, function($tags) {
                foreach($tags as $tag) {
                    $tag = substr($tag, 8, strlen($tag) - 8);
                    return "<?php foreach$tag: ?>";
                }
            }, $line_buffer);
        }

        public function ParseSwitchTagExpr(string $line_buffer): string {
            return preg_replace_callback(JEWEL_SWITCH_TAG_REGEX, function($tags) {
                foreach($tags as $tag) {
                    $tag = substr($tag, 7, strlen($tag) - 6);
                    return "<?php switch $tag: ?>";
                }
            }, $line_buffer);
        }

        public function ParseCaseTagExpr(string $line_buffer): string {
            return preg_replace_callback(JEWEL_CASE_TAG_REGEX, function($tags) {
                foreach($tags as $tag) {
                    $tag = substr($tag, 6, strlen($tag) - 7);
                    return "<?php case $tag: ?>";
                }
            }, $line_buffer);
        }

        public function ParseForTagExpr(string $line_buffer): string {
            return preg_replace_callback(JEWEL_FOR_TAG_REGEX, function($tags) {
                foreach($tags as $tag) {
                    $tag = substr($tag, 4, strlen($tag) - 4);
                    return "<?php for $tag: ?>";
                }
            }, $line_buffer);
        }

        public function ParseWhileTagExpr(string $line_buffer): string {
            return preg_replace_callback(JEWEL_WHILE_TAG_REGEX, function($tags) {
                foreach($tags as $tag) {
                    $tag = substr($tag, 6, strlen($tag) - 6);
                    return "<?php while $tag: ?>";
                }
            }, $line_buffer);
        }

        public function TransformLine(int $line_number, string $line_buffer): string {
            if($this->HasExpression($line_buffer, JEWEL_CONTENT_TAG_REGEX)) $line_buffer = $this->ParseContentTagExpr($line_buffer);
            if($this->HasExpression($line_buffer, JEWEL_IF_TAG_REGEX)) $line_buffer = $this->ParseIfTagExpr($line_buffer);
            if($this->HasExpression($line_buffer, JEWEL_ELSEIF_TAG_REGEX)) $line_buffer = $this->ParseElseIfTagExpr($line_buffer);
            if($this->HasExpression($line_buffer, JEWEL_FOREACH_TAG_REGEX)) $line_buffer = $this->ParseForeachTagExpr($line_buffer);
            if($this->HasExpression($line_buffer, JEWEL_SWITCH_TAG_REGEX)) $line_buffer = $this->ParseSwitchTagExpr($line_buffer);
            if($this->HasExpression($line_buffer, JEWEL_CASE_TAG_REGEX)) $line_buffer = $this->ParseCaseTagExpr($line_buffer);
            if($this->HasExpression($line_buffer, JEWEL_FOR_TAG_REGEX)) $line_buffer = $this->ParseForTagExpr($line_buffer);
            if($this->HasExpression($line_buffer, JEWEL_WHILE_TAG_REGEX)) $line_buffer = $this->ParseWhileTagExpr($line_buffer);

            // Smooth transformation
            $line_buffer = str_replace("*endif", "<?php endif; ?>", $line_buffer);
            $line_buffer = str_replace("*else", "<?php else: ?>", $line_buffer);
            $line_buffer = str_replace("*endforeach", "<?php endforeach; ?>", $line_buffer);
            $line_buffer = str_replace("*endswitch", "<?php endswitch; ?>", $line_buffer);
            $line_buffer = str_replace("*break", "<?php break; ?>", $line_buffer);
            $line_buffer = str_replace("*continue", "<?php continue; ?>", $line_buffer);
            $line_buffer = str_replace("*endfor", "<?php endfor; ?>", $line_buffer);
            $line_buffer = str_replace("*endwhile", "<?php endwhile; ?>", $line_buffer);
            
            return $line_buffer;
        }

        public function TransformLines(array $lines): string {
            $dist = "";

            foreach($lines as $line_number => $line_buffer) {
                $dist .= $this->TransformLine($line_number, $line_buffer);
            }

            return $dist;
        }
    }