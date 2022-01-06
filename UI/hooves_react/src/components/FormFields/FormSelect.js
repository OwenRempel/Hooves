export default function FormSelect({ inputLabel, options, ...rest }) {
    const { name } = rest;
  
    if (!options) return null;
  
    return (
      <div className='inputItem'>
        <label htmlFor={name}>{inputLabel || name}</label>
        <select id={name} {...rest}>
          {options.map(({ option, ...opt }, index) => (
            <option key={index} {...opt}>
              {option}
            </option>
          ))}
        </select>
      </div>
    );
  }