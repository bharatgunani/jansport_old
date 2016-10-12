<?php
/**
 * This file is part of PDepend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2013, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @since     0.9.6
 */

namespace PDepend\Source\AST;

use PDepend\Source\ASTVisitor\ASTVisitor;

/**
 * This class represents a formal parameter within the signature of a function,
 * method or closure.
 *
 * Formal parameters can include a type hint, a by reference identifier and a
 * default value. The only mandatory part is the parameter identifier.
 *
 * @copyright 2008-2013 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 * @since     0.9.6
 */
class ASTFormalParameter extends ASTNode
{
    /**
     * This method will return <b>true</b> when the parameter is passed by
     * reference.
     *
     * @return boolean
     */
    public function isPassedByReference()
    {
        return $this->getMetadataBoolean(5);
    }

    /**
     * This method can be used to mark this parameter as passed by reference.
     *
     * @return void
     */
    public function setPassedByReference()
    {
        return $this->setMetadataBoolean(5, true);
    }

    /**
     * Accept method of the visitor design pattern. This method will be called
     * by a visitor during tree traversal.
     *
     * @param  \PDepend\Source\ASTVisitor\ASTVisitor $visitor The calling visitor instance.
     * @param  mixed                                 $data
     * @return mixed
     * @since  0.9.12
     */
    public function accept(ASTVisitor $visitor, $data = null)
    {
        return $visitor->visitFormalParameter($this, $data);
    }

    /**
     * Returns the total number of the used property bag.
     *
     * @return integer
     * @since  0.10.4
     * @see    \PDepend\Source\AST\ASTNode#getMetadataSize()
     */
    protected function getMetadataSize()
    {
        return 6;
    }
}
