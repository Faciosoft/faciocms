<?php
    namespace Jewel;

    use Jewel\CompilerInterface;
    use Jewel\Compiler\Concerns\Lines;
    use Jewel\Compiler\Concerns\Buffer;
    use Jewel\ValidInterface;
    use Jewel\Valid\Concerns\Valid;
    use Jewel\ErrorInterface;
    use Jewel\Error\Concerns\Error;
    use Jewel\ExpressionableInterface;
    use Jewel\Expressionable\Concerns\Expressionable;

    class Compiler implements 
        CompilerInterface, 
        ValidInterface,
        ErrorInterface,
        ExpressionableInterface {

        use Lines;
        use Buffer;
        use Expressionable;
        use Error;
        use Valid;
        
        /**
         * @name source_buffer
         * @type {string}
         * 
         * Contains layout source buffer (file content)
         */
        private string $source_buffer;
        
        public function Run(string $source_file, string $dist_file): void {
            if(!$this->Valid($source_file)) {
                $this->PreprocessError("File $source_file is not valid layout file!");
                return;
            }

            // Read file contents
            $this->source_buffer = $this->ReadSourceBuffer($source_file);

            // Generates lines from buffer
            $lines = $this->BufferToLines($this->source_buffer);

            // Generating dist buffer
            $dist_buffer = $this->TransformLines($lines);

            // Save changes
            file_put_contents($dist_file, $dist_buffer);
        }
    }