export default function FormTextarea({ textareaLabel, ...rest }) {
    const { name } = rest;
  
    return (
      <div className='inputItem'>
        <label htmlFor={name}>{textareaLabel || name}</label>
        <textarea id={name} {...rest} />
      </div>
    );
  }